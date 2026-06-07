<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\Ruangan;
use App\Http\Requests\SimpanMataKuliahRequest;
use Illuminate\Support\Facades\DB;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliah = MataKuliah::with('kelas.dosen', 'kelas.ruangan.gedung')->get();
        $dosen = Dosen::all();
        $ruangan = Ruangan::with('gedung')->get();
        return view('mata-kuliah.index', compact('mataKuliah', 'dosen', 'ruangan'));
    }

    public function store(SimpanMataKuliahRequest $request)
    {
        DB::transaction(function () use ($request) {
            $idMataKuliah = $request->mata_kuliah_id;

            // Jika tidak pilih dari dropdown, coba cari berdasarkan Kode MK yang diinput manual
            if (!$idMataKuliah && $request->kode) {
                $mkAda = MataKuliah::where('kode', $request->kode)->first();
                if ($mkAda) {
                    $idMataKuliah = $mkAda->id;
                }
            }

            if (!$idMataKuliah) {
                $mk = MataKuliah::create([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'sks' => $request->sks,
                    'tipe' => $request->tipe,
                    'semester' => $request->semester,
                ]);
                $idMataKuliah = $mk->id;
            }

            Kelas::create([
                'mata_kuliah_id' => $idMataKuliah,
                'dosen_id' => $request->dosen_id,
                'sks' => $request->sks,
                'tipe' => $request->tipe,
                'nama' => $request->nama_kelas,
            ]);
        });

        return redirect()->back()->with('success', 'Plotting Mata Kuliah berhasil disimpan.');
    }

    public function update(SimpanMataKuliahRequest $request, MataKuliah $mataKuliah)
    {
        $mataKuliah->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'sks' => $request->sks,
            'tipe' => $request->tipe,
            'semester' => $request->semester,
        ]);
        return redirect()->back()->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function updateOffering(SimpanMataKuliahRequest $request, Kelas $kelas)
    {
        $kelas->update([
            'dosen_id' => $request->dosen_id,
            'sks' => $request->sks,
            'tipe' => $request->tipe,
        ]);
        return redirect()->back()->with('success', 'Plotting berhasil diperbarui.');
    }

    public function destroyOffering(Kelas $kelas)
    {
        $mk = $kelas->mataKuliah;
        $kelas->delete();

        // Jika tidak ada kelas lagi, hapus matkulnya sekalian agar bersih
        if ($mk->kelas()->count() === 0) {
            $mk->delete();
        }

        return redirect()->back()->with('success', 'Plotting berhasil dihapus.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return redirect()->back()->with('success', 'Mata Kuliah beserta seluruh plottingnya berhasil dihapus.');
    }
}
