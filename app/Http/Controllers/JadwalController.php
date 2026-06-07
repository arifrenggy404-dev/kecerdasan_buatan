<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\Ruangan;
use App\Models\Gedung;
use App\Models\MataKuliah;
use App\Models\Jadwal;
use App\Models\SlotWaktu;
use App\Models\Pengaturan;
use App\Services\AlgoritmaGenetikaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalController extends Controller
{
    public function index()
    {
        $jumlahDosen = Dosen::count();
        $jumlahMataKuliah = MataKuliah::count();
        $jumlahRuangan = Ruangan::count();
        $jumlahGedung = Gedung::count();
        $jumlahKelas = Kelas::count();

        $dosen = Dosen::all();
        $ruangan = Ruangan::all();
        $kelas = Kelas::with(['mataKuliah', 'dosen'])->get();
        
        // Ambil semua jadwal
        $jadwal = Jadwal::with(['kelas.mataKuliah', 'kelas.dosen', 'ruangan', 'hari', 'slotWaktuMulai'])
            ->get()
            ->sortBy(['hari_id', 'slot_waktu_mulai_id']);

        return view('jadwal.index', compact(
            'jumlahDosen', 
            'jumlahMataKuliah', 
            'jumlahRuangan', 
            'jumlahGedung', 
            'jumlahKelas',
            'dosen', 
            'ruangan', 
            'kelas', 
            'jadwal'
        ));
    }

    public function buat(AlgoritmaGenetikaService $layananAg)
    {
        // Validasi ketersediaan data dasar
        $errors = $layananAg->periksaPersyaratan();
        if (!empty($errors)) {
            $pesan = 'Gagal memulai: ' . implode(' ', $errors);
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $pesan], 422);
            }
            return redirect()->back()->with('error', $pesan);
        }

        // 10 Menit waktu eksekusi maksimal
        set_time_limit(600);

        // 1. Inisialisasi
        $populasi = $layananAg->inisialisasiPopulasi();
        $generasiMaksimal = 3000;
        $kromosomTerbaik = null;
        $kebugaranTerbaik = 0;

        // 2. Evolusi hingga Kebugaran = 1.0 (MUTLAK NOL BENTROK)
        for ($i = 0; $i < $generasiMaksimal; $i++) {
            $populasiTerskor = $layananAg->evolusi($populasi, $i);
            
            // Ambil yang terbaik dari generasi ini
            $terbaikSaatIni = $populasiTerskor[0]['c'];
            $kebugaranSaatIni = $populasiTerskor[0]['f'];

            // Update Terbaik Keseluruhan
            if ($kebugaranSaatIni > $kebugaranTerbaik) {
                $kebugaranTerbaik = $kebugaranSaatIni;
                $kromosomTerbaik = $terbaikSaatIni;
            }

            // Siapkan populasi untuk generasi berikutnya
            $populasi = $populasiTerskor;

            // BERHENTI JIKA NOL PENALTI (1.0)
            if ($kebugaranTerbaik >= 1.0) {
                break;
            }
        }

        // 3. Simpan MUTLAK hanya jika SEMPURNA (Kebugaran = 1.0 / Nol Bentrok)
        if ($kromosomTerbaik && $kebugaranTerbaik >= 1.0) {
            \Illuminate\Support\Facades\DB::transaction(function() use ($kromosomTerbaik, $layananAg) {
                Jadwal::query()->delete();

                $idBatch = (string) Str::uuid();
                $jadwalFinal = $layananAg->petakanIndeksKeId($kromosomTerbaik);

                foreach ($jadwalFinal as $data) {
                    Jadwal::create([
                        'kelas_id'           => $data['kelas_id'],
                        'ruangan_id'         => $data['ruangan_id'],
                        'hari_id'            => $data['hari_id'],
                        'slot_waktu_mulai_id' => $data['slot_id'],
                        'id_batch'           => $idBatch,
                    ]);
                }
            });

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal SEMPURNA (Nol Bentrok) berhasil dihasilkan dalam ' . ($i + 1) . ' generasi!'
                ]);
            }

            return redirect()->back()->with('success', 'Jadwal SEMPURNA (Nol Bentrok) berhasil dihasilkan dalam ' . ($i + 1) . ' generasi!');
        }

        // 4. JIKA GAGAL
        $jumlahPenalti = ($kebugaranTerbaik > 0) ? (round(1 / $kebugaranTerbaik) - 1) : 'Banyak';
        $pesanError = "GAGAL! Sistem tidak menemukan jadwal yang benar-benar bersih. Masih ada {$jumlahPenalti} bentrok. Data TIDAK disimpan ke database.";

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $pesanError
            ], 422);
        }

        return redirect()->back()->with('error', $pesanError . " Silakan coba buat ulang atau tambah kapasitas ruangan/hari.");
    }

    public function hapusSemua()
    {
        Jadwal::query()->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Seluruh hasil jadwal berhasil dihapus.'
            ]);
        }

        return redirect()->back()->with('success', 'Seluruh hasil jadwal berhasil dihapus.');
    }

    public function eksporCsv(Request $request)
    {
        $jadwal = Jadwal::with(['kelas.mataKuliah', 'kelas.dosen', 'ruangan', 'hari', 'slotWaktuMulai'])
            ->get()
            ->sortBy(['hari_id', 'slot_waktu_mulai_id']);

        if ($jadwal->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jadwal untuk diekspor.');
        }

        $jadwalTerkelompok = $jadwal->groupBy(function($j) {
            return $j->kelas?->mataKuliah?->semester ?? 'Lainnya';
        })->sortKeys();

        $durasiSks = Pengaturan::getValue('durasi_sks', 50);
        
        $namaFileMentah = $request->query('filename') ?: "jadwal_perkuliahan_" . date('Y-m-d_H-i');
        $namaFile = Str::slug($namaFileMentah) . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$namaFile",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $kolom = ['Hari', 'Waktu Mulai', 'Waktu Selesai', 'Semester', 'Mata Kuliah', 'SKS', 'Dosen', 'Gedung', 'Ruangan'];

        $callback = function() use ($jadwalTerkelompok, $kolom, $durasiSks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $kolom);

            foreach ($jadwalTerkelompok as $semester => $jadwalSemester) {
                fputcsv($file, ['', '', '', "--- SEMESTER $semester ---", '', '', '', '', '']);

                foreach ($jadwalSemester as $j) {
                    $jamMulaiStr = $j->slotWaktuMulai?->jam_mulai ?? '00:00';
                    $jamMulai = \Carbon\Carbon::parse($jamMulaiStr);
                    $sks = $j->kelas?->sks ?? 0;
                    $totalMenit = $sks * $durasiSks;
                    $jamSelesai = $jamMulai->copy()->addMinutes($totalMenit);

                    fputcsv($file, [
                        $j->hari?->nama ?? '-',
                        $jamMulai->format('H:i'),
                        $jamSelesai->format('H:i'),
                        $semester,
                        $j->kelas?->mataKuliah?->nama ?? '-',
                        $sks,
                        $j->kelas?->dosen?->nama ?? '-',
                        $j->ruangan?->gedung?->nama ?? '-',
                        $j->ruangan?->nama ?? '-'
                    ]);
                }
                fputcsv($file, []);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function eksporPdf(Request $request)
    {
        if (!class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            return redirect()->back()->with('error', 'Fitur PDF memerlukan package dompdf. Silakan jalankan: composer require barryvdh/laravel-dompdf');
        }

        $jadwal = Jadwal::with(['kelas.mataKuliah', 'kelas.dosen', 'ruangan', 'hari', 'slotWaktuMulai'])
            ->get()
            ->sortBy(['hari_id', 'slot_waktu_mulai_id']);

        if ($jadwal->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada jadwal untuk diekspor.');
        }

        $jadwalTerkelompok = $jadwal->groupBy(function($j) {
            return $j->kelas?->mataKuliah?->semester ?? 'Lainnya';
        })->sortKeys();

        $durasiSks = Pengaturan::getValue('durasi_sks', 50);
        
        $namaFileMentah = $request->query('filename') ?: "jadwal_perkuliahan_" . date('Y-m-d_H-i');
        $namaFile = Str::slug($namaFileMentah) . ".pdf";

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('jadwal.pdf', [
            'jadwalTerkelompok' => $jadwalTerkelompok,
            'durasiSks' => $durasiSks
        ]);
        return $pdf->download($namaFile);
    }
}
