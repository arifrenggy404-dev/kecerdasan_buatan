<?php

namespace App\Services;

use App\Models\Kelas;
use App\Models\Ruangan;
use App\Models\Hari;
use App\Models\SlotWaktu;
use App\Models\Pengaturan;

class AlgoritmaGenetikaService
{
    protected array $kelas;
    protected array $ruangan;
    protected array $hari;       // Hari yang difilter (aktif)
    protected array $slotWaktu;  // Semua SlotWaktu yang mungkin dalam jam operasional
    protected array $menitSlot;  // Menit yang sudah dihitung [idx => ['mulai' => min, 'selesai' => min]]
    protected array $istirahat;  // Waktu istirahat spesifik hari
    protected int $ukuranPopulasi = 100;
    protected float $tingkatMutasi = 0.05;
    protected int $generasiMaksimal = 5000;

    protected array $menitIstirahat; // Menit istirahat yang sudah dihitung

    public function __construct()
    {
        $this->kelas = Kelas::join('mata_kuliah', 'kelas.mata_kuliah_id', '=', 'mata_kuliah.id')
            ->select('kelas.id', 'kelas.dosen_id', 'kelas.sks', 'kelas.tipe', 'mata_kuliah.semester')
            ->get()
            ->toArray();
        $this->ruangan = Ruangan::select('id', 'nama', 'tipe')->get()->toArray();
        
        $hariAktifId = Pengaturan::getValue('hari_aktif', [1, 2, 3, 4, 5]);
        $this->hari = Hari::whereIn('id', $hariAktifId)->orderBy('id')->get()->toArray();
        
        $operasional = Pengaturan::getValue('jam_operasional', ['mulai' => '07:00', 'selesai' => '22:00']);
        $this->istirahat = Pengaturan::getValue('jam_istirahat', []);
        $durasiSks = Pengaturan::getValue('durasi_sks', 50);

        // Hitung menit istirahat di awal
        $this->menitIstirahat = [];
        foreach ($this->istirahat as $i) {
            $this->menitIstirahat[] = [
                'hari_id' => $i['hari_id'],
                'mulai'  => $this->waktuKeMenit($i['mulai']),
                'selesai'    => $this->waktuKeMenit($i['selesai']),
            ];
        }

        $this->pastikanSlotWaktuTersedia($operasional['mulai'], $operasional['selesai'], $durasiSks);

        $this->slotWaktu = SlotWaktu::orderBy('jam_mulai')
            ->whereTime('jam_mulai', '>=', $operasional['mulai'])
            ->whereTime('jam_selesai', '<=', $operasional['selesai'])
            ->get()
            ->filter(function($slot) use ($durasiSks) {
                $durasi = (strtotime($slot->jam_selesai) - strtotime($slot->jam_mulai)) / 60;
                return $durasi == $durasiSks;
            })
            ->values()
            ->toArray();

        $this->menitSlot = [];
        foreach ($this->slotWaktu as $idx => $slot) {
            $this->menitSlot[$idx] = [
                'mulai' => $this->waktuKeMenit($slot['jam_mulai']),
                'selesai'   => $this->waktuKeMenit($slot['jam_selesai'])
            ];
        }
    }

    protected function apakahWaktuIstirahat($hariId, $slotIdx, $sks): bool
    {
        $akhirSlotIdx = $slotIdx + $sks - 1;
        if (!isset($this->menitSlot[$slotIdx]) || !isset($this->menitSlot[$akhirSlotIdx])) {
            return true;
        }

        $mulaiKelas = $this->menitSlot[$slotIdx]['mulai'];
        $akhirKelas = $this->menitSlot[$akhirSlotIdx]['selesai'];

        foreach ($this->menitIstirahat as $mi) {
            if ($mi['hari_id'] != 0 && $mi['hari_id'] != $hariId) continue;

            // Cek tumpang tindih: (MulaiA < SelesaiB) dan (SelesaiA > MulaiB)
            if ($mulaiKelas < $mi['selesai'] && $akhirKelas > $mi['mulai']) {
                return true;
            }
        }
        return false;
    }

    /**
     * Memeriksa apakah data yang tersedia cukup untuk menjalankan algoritma.
     */
    public function periksaPersyaratan(): array
    {
        $errors = [];
        if (empty($this->kelas)) $errors[] = "Belum ada data Mata Kuliah / Plotting Dosen.";
        if (empty($this->ruangan)) $errors[] = "Belum ada data Ruangan.";
        if (empty($this->hari)) $errors[] = "Belum ada Hari Kerja yang aktif di Pengaturan.";
        if (empty($this->slotWaktu)) $errors[] = "Tidak ada Slot Waktu yang tersedia pada Jam Operasional tersebut.";
        
        return $errors;
    }

    protected function pastikanSlotWaktuTersedia($mulai, $selesai, $durasiMenit)
    {
        // Bersihkan seluruh slot lama untuk mencegah "Slot Hantu" antar run
        SlotWaktu::query()->delete();

        $waktuMulai = strtotime($mulai);
        $batasWaktuSelesai = strtotime($selesai);
        
        while ($waktuMulai < $batasWaktuSelesai) {
            $slotSelesai = strtotime('+' . $durasiMenit . ' minutes', $waktuMulai);
            if ($slotSelesai > $batasWaktuSelesai) break;

            $waktuMulaiStr = date('H:i:s', $waktuMulai);
            $waktuSelesaiStr = date('H:i:s', $slotSelesai);

            $exists = SlotWaktu::where('jam_mulai', $waktuMulaiStr)
                ->where('jam_selesai', $waktuSelesaiStr)
                ->exists();

            if (!$exists) {
                SlotWaktu::create([
                    'nama' => 'Slot ' . date('H:i', $waktuMulai),
                    'jam_mulai' => $waktuMulaiStr,
                    'jam_selesai' => $waktuSelesaiStr
                ]);
            }

            $waktuMulai = $slotSelesai;
        }
    }

    public function inisialisasiPopulasi(): array
    {
        $populasi = [];
        for ($i = 0; $i < $this->ukuranPopulasi; $i++) {
            $populasi[] = $this->buatKromosomAcak();
        }
        return $populasi;
    }

    protected function buatKromosomAcak(): array
    {
        $kromosom = [];
        $ruanganPerTipe = [];
        foreach ($this->ruangan as $idx => $r) {
            $ruanganPerTipe[$r['tipe']][] = $idx;
        }

        foreach ($this->kelas as $k) {
            $sks = $k['sks'] ?? 3;
            $maxSlotIdx = count($this->slotWaktu) - $sks;

            if ($maxSlotIdx < 0) continue; 

            $indeksRuanganKompatibel = $ruanganPerTipe[$k['tipe']] ?? array_keys($this->ruangan);
            $ruanganIdx = $indeksRuanganKompatibel[array_rand($indeksRuanganKompatibel)];

            // Cari slot yang bukan waktu istirahat
            $hariIdx = array_rand($this->hari);
            $slotIdx = rand(0, $maxSlotIdx);
            
            // Coba hingga 10 kali untuk menemukan slot yang bukan istirahat
            for ($retry = 0; $retry < 10; $retry++) {
                if (!$this->apakahWaktuIstirahat($this->hari[$hariIdx]['id'], $slotIdx, $sks)) {
                    break;
                }
                $hariIdx = array_rand($this->hari);
                $slotIdx = rand(0, $maxSlotIdx);
            }

            $kromosom[] = [
                'kelas_id' => $k['id'],
                'dosen_id' => $k['dosen_id'],
                'tipe_kelas' => $k['tipe'],
                'semester'    => $k['semester'],
                'ruangan_idx'    => $ruanganIdx,
                'hari_idx'     => $hariIdx, 
                'slot_idx'    => $slotIdx,    
                'sks'         => $sks,
            ];
        }
        return $kromosom;
    }

    public function hitungKebugaran(array $kromosom): float
    {
        $penalti = 0;
        $jumlahGen = count($kromosom);

        // Pra-hitung data gen dalam bentuk integer menit
        $genDenganMenit = [];
        foreach ($kromosom as $gen) {
            $menitSlotMulai = $this->menitSlot[$gen['slot_idx']];
            $akhirSlotIdx = $gen['slot_idx'] + $gen['sks'] - 1;
            
            if ($akhirSlotIdx >= count($this->slotWaktu)) {
                $penalti += 1000000;
                $genDenganMenit[] = null;
                continue;
            }

            // Cek istirahat
            if ($this->apakahWaktuIstirahat($this->hari[$gen['hari_idx']]['id'], $gen['slot_idx'], $gen['sks'])) {
                $penalti += 1000000;
            }

            $menitSlotAkhir = $this->menitSlot[$akhirSlotIdx];

            $genDenganMenit[] = [
                'dosen_id' => $gen['dosen_id'],
                'ruangan_id'     => $this->ruangan[$gen['ruangan_idx']]['id'],
                'hari_idx'     => $gen['hari_idx'],
                'menit_mulai'   => $menitSlotMulai['mulai'],
                'menit_akhir'   => $menitSlotAkhir['selesai'],
                'tipe'        => $gen['tipe_kelas'],
                'semester'    => $gen['semester'],
                'tipe_ruangan'   => $this->ruangan[$gen['ruangan_idx']]['tipe']
            ];
        }

        for ($i = 0; $i < $jumlahGen; $i++) {
            $g1 = $genDenganMenit[$i];
            if (!$g1) continue;

            if ($g1['tipe'] != $g1['tipe_ruangan']) {
                $penalti += 1000000;
            }

            for ($j = $i + 1; $j < $jumlahGen; $j++) {
                $g2 = $genDenganMenit[$j];
                if (!$g2) continue;

                if ($g1['hari_idx'] == $g2['hari_idx']) {
                    $apakahBentrok = ($g1['menit_mulai'] < $g2['menit_akhir']) && ($g1['menit_akhir'] > $g2['menit_mulai']);

                    if ($apakahBentrok) {
                        // 1. Bentrok Dosen (Hanya jika dosen sudah diplot)
                        if ($g1['dosen_id'] != null && $g1['dosen_id'] == $g2['dosen_id']) {
                            $penalti += 1000000;
                        }

                        // 2. Bentrok Ruangan
                        if ($g1['ruangan_id'] == $g2['ruangan_id']) {
                            $penalti += 1000000;
                        }

                        // 3. Bentrok Semester (Satu semester tidak boleh di waktu yang sama)
                        if ($g1['semester'] != null && $g1['semester'] == $g2['semester']) {
                            $penalti += 1000000;
                        }
                    }
                }
            }
        }

        return ($penalti === 0) ? 1.0 : (1 / (1 + $penalti));
    }

    protected function waktuKeMenit(string $waktu): int
    {
        $bagian = explode(':', $waktu);
        return ((int)$bagian[0] * 60) + (int)$bagian[1];
    }

    public function evolusi(array $populasi, int $generasiIdx = 0): array
    {
        $skor = [];
        foreach ($populasi as $p) {
            $kromosom = isset($p['c']) ? $p['c'] : $p;
            $skor[] = ['c' => $kromosom, 'f' => $this->hitungKebugaran($kromosom)];
        }
        usort($skor, fn($a, $b) => $b['f'] <=> $a['f']);

        $tingkatMutasiSaatIni = $this->tingkatMutasi;
        if ($generasiIdx > 500 && $skor[0]['f'] < 1.0) {
            $tingkatMutasiSaatIni = 0.2; 
        }

        $populasiBaru = [];
        $jumlahElitisme = max(2, round(count($populasi) * 0.1));
        for ($i = 0; $i < $jumlahElitisme; $i++) {
            $populasiBaru[] = $skor[$i]['c'];
        }

        while (count($populasiBaru) < count($populasi)) {
            $p1 = $this->seleksiTurnamen($skor);
            $p2 = $this->seleksiTurnamen($skor);

            $anak = $this->pindahSilang($p1, $p2);
            $anak = $this->mutasi($anak, $tingkatMutasiSaatIni);
            $populasiBaru[] = $anak;
        }

        $skorAkhir = [];
        foreach ($populasiBaru as $c) {
            $skorAkhir[] = ['c' => $c, 'f' => $this->hitungKebugaran($c)];
        }
        usort($skorAkhir, fn($a, $b) => $b['f'] <=> $a['f']);

        return $skorAkhir;
    }

    protected function seleksiTurnamen(array $skor): array
    {
        $ukuranTurnamen = 5;
        $terbaik = null;
        for ($i = 0; $i < $ukuranTurnamen; $i++) {
            $idx = rand(0, count($skor) - 1);
            $peserta = $skor[$idx];
            if ($terbaik === null || $peserta['f'] > $terbaik['f']) {
                $terbaik = $peserta;
            }
        }
        return $terbaik['c'];
    }

    public function pindahSilang(array $p1, array $p2): array
    {
        $titikPotong = rand(0, count($p1) - 1);
        $anak = [];
        for ($i = 0; $i < count($p1); $i++) {
            $anak[$i] = ($i < $titikPotong) ? $p1[$i] : $p2[$i];
        }
        return $anak;
    }

    public function mutasi(array $kromosom, ?float $lajuOverride = null): array
    {
        $laju = $lajuOverride ?? $this->tingkatMutasi;
        $ruanganPerTipe = [];
        foreach ($this->ruangan as $idx => $r) {
            $ruanganPerTipe[$r['tipe']][] = $idx;
        }

        // Cek keamanan
        if (empty($kromosom) || empty($this->hari) || empty($this->ruangan)) {
            return $kromosom;
        }

        if ((mt_rand() / mt_getrandmax()) < 0.05) {
            $idx1 = array_rand($kromosom);
            $idx2 = array_rand($kromosom);
            
            $hariTemp = $kromosom[$idx1]['hari_idx'];
            $slotTemp = $kromosom[$idx1]['slot_idx'];
            $ruanganTemp = $kromosom[$idx1]['ruangan_idx'];
            
            $kromosom[$idx1]['hari_idx'] = $kromosom[$idx2]['hari_idx'];
            $kromosom[$idx1]['slot_idx'] = $kromosom[$idx2]['slot_idx'];
            $kromosom[$idx1]['ruangan_idx'] = $kromosom[$idx2]['ruangan_idx'];
            
            $kromosom[$idx2]['hari_idx'] = $hariTemp;
            $kromosom[$idx2]['slot_idx'] = $slotTemp;
            $kromosom[$idx2]['ruangan_idx'] = $ruanganTemp;
        }

        foreach ($kromosom as &$gen) {
            if ((mt_rand() / mt_getrandmax()) < $laju) {
                $maxSlotIdx = count($this->slotWaktu) - $gen['sks'];
                if ($maxSlotIdx >= 0) {
                    $indeksHariBaru = array_rand($this->hari);
                    $indeksSlotBaru = rand(0, $maxSlotIdx);

                    // Coba hindari waktu istirahat
                    for ($retry = 0; $retry < 5; $retry++) {
                        if (!$this->apakahWaktuIstirahat($this->hari[$indeksHariBaru]['id'], $indeksSlotBaru, $gen['sks'])) {
                            break;
                        }
                        $indeksHariBaru = array_rand($this->hari);
                        $indeksSlotBaru = rand(0, $maxSlotIdx);
                    }

                    $gen['hari_idx'] = $indeksHariBaru;
                    $gen['slot_idx'] = $indeksSlotBaru;
                }

                $indeksRuanganKompatibel = $ruanganPerTipe[$gen['tipe_kelas']] ?? array_keys($this->ruangan);
                if (!empty($indeksRuanganKompatibel)) {
                    $gen['ruangan_idx'] = $indeksRuanganKompatibel[array_rand($indeksRuanganKompatibel)];
                }
            }
        }
        return $kromosom;
    }

    public function petakanIndeksKeId(array $kromosom): array
    {
        $akhir = [];
        foreach ($kromosom as $gen) {
            $akhir[] = [
                'kelas_id' => $gen['kelas_id'],
                'ruangan_id'     => $this->ruangan[$gen['ruangan_idx']]['id'],
                'hari_id'      => $this->hari[$gen['hari_idx']]['id'],
                'slot_id'     => $this->slotWaktu[$gen['slot_idx']]['id'],
            ];
        }
        return $akhir;
    }
}
