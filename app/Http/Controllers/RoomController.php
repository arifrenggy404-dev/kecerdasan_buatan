<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use App\Http\Requests\StoreRoomRequest;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('building')->get();
        $buildings = Building::all();
        return view('rooms.index', compact('rooms', 'buildings'));
    }

    public function store(StoreRoomRequest $request)
    {
        Room::create($request->validated());
        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update(StoreRoomRequest $request, Room $room)
    {
        $room->update($request->validated());
        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
    }
}
