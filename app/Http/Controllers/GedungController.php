<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Http\Requests\SimpanGedungRequest;

class GedungController extends Controller
{
    public function index()
    {
        $gedung = Gedung::all();
        return view('gedung.index', compact('gedung'));
    }

    public function store(SimpanGedungRequest $request)
    {
        Gedung::create($request->validated());
        return redirect()->back()->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function update(SimpanGedungRequest $request, Gedung $gedung)
    {
        $gedung->update($request->validated());
        return redirect()->back()->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();
        return redirect()->back()->with('success', 'Gedung berhasil dihapus.');
    }
}
