<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Http\Requests\SimpanDosenRequest;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::all();
        return view('dosen.index', compact('dosen'));
    }

    public function store(SimpanDosenRequest $request)
    {
        Dosen::create($request->validated());
        return redirect()->back()->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function update(SimpanDosenRequest $request, Dosen $dosen)
    {
        $dosen->update($request->validated());
        return redirect()->back()->with('success', 'Dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return redirect()->back()->with('success', 'Dosen berhasil dihapus.');
    }
}
