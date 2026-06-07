<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Gedung;
use App\Http\Requests\SimpanRuanganRequest;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::with('gedung')->get();
        $gedung = Gedung::all();
        return view('ruangan.index', compact('ruangan', 'gedung'));
    }

    public function store(SimpanRuanganRequest $request)
    {
        Ruangan::create($request->validated());
        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update(SimpanRuanganRequest $request, Ruangan $ruangan)
    {
        $ruangan->update($request->validated());
        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
    }
}
