<?php

namespace App\Http\Controllers;

use App\Models\Hari;
use App\Models\Pengaturan;
use App\Http\Requests\PerbaruiPengaturanRequest;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $semuaHari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        $hariAktif = Pengaturan::getValue('hari_aktif', [1, 2, 3, 4, 5]);
        $jamOperasional = Pengaturan::getValue('jam_operasional', ['mulai' => '07:30', 'selesai' => '17:00']);
        $jamIstirahat = Pengaturan::getValue('jam_istirahat', [['mulai' => '12:00', 'selesai' => '13:00']]);
        $durasiSks = Pengaturan::getValue('durasi_sks', 50);

        return view('pengaturan.index', compact('semuaHari', 'hariAktif', 'jamOperasional', 'jamIstirahat', 'durasiSks'));
    }

    public function update(PerbaruiPengaturanRequest $request)
    {
        $semuaHari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        $idHariAktif = $request->hari_aktif ?? [];
        
        // Pastikan setiap hari yang diaktifkan ada di database
        foreach ($idHariAktif as $id) {
            if (isset($semuaHari[$id])) {
                Hari::firstOrCreate(
                    ['id' => $id],
                    ['nama' => $semuaHari[$id]]
                );
            }
        }

        Pengaturan::setValue('hari_aktif', array_map('intval', $idHariAktif));
        Pengaturan::setValue('durasi_sks', (int) $request->durasi_sks);
        
        Pengaturan::setValue('jam_operasional', [
            'mulai' => $request->jam_operasional_mulai,
            'selesai' => $request->jam_operasional_selesai,
        ]);

        $istirahat = [];
        if ($request->has('jam_istirahat_mulai')) {
            foreach ($request->jam_istirahat_mulai as $indeks => $mulai) {
                $selesai = $request->jam_istirahat_selesai[$indeks] ?? null;
                $hariId = $request->jam_istirahat_hari[$indeks] ?? 0;

                if ($mulai && $selesai) {
                    $istirahat[] = [
                        'hari_id' => (int) $hariId,
                        'mulai'  => $mulai,
                        'selesai'    => $selesai,
                    ];
                }
            }
        }
        Pengaturan::setValue('jam_istirahat', $istirahat);

        return redirect()->back()->with('success', 'Pengaturan batasan waktu berhasil diperbarui.');
    }
}
