<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Http\Requests\StoreLecturerRequest;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::all();
        return view('lecturers.index', compact('lecturers'));
    }

    public function store(StoreLecturerRequest $request)
    {
        Lecturer::create($request->validated());
        return redirect()->back()->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function update(StoreLecturerRequest $request, Lecturer $lecturer)
    {
        $lecturer->update($request->validated());
        return redirect()->back()->with('success', 'Dosen berhasil diperbarui.');
    }

    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return redirect()->back()->with('success', 'Dosen berhasil dihapus.');
    }
}
