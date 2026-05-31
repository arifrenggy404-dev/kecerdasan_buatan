<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Http\Requests\StoreBuildingRequest;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('buildings.index', compact('buildings'));
    }

    public function store(StoreBuildingRequest $request)
    {
        Building::create($request->validated());
        return redirect()->back()->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function update(StoreBuildingRequest $request, Building $building)
    {
        $building->update($request->validated());
        return redirect()->back()->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->back()->with('success', 'Gedung berhasil dihapus.');
    }
}
