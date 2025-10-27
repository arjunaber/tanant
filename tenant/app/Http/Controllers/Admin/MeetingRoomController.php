<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller; 
use App\Models\MeetingRoom;
use App\Models\Category;
use App\Http\Requests\StoreMeetingRoomRequest;
use App\Http\Requests\UpdateMeetingRoomRequest;
use Illuminate\Http\Request;

class MeetingRoomController extends Controller
{
    // Tampilkan semua ruangan (admin + user)
    public function index(Request $request)
    {
        $query = MeetingRoom::with('categories');

        // Fitur tambahan: search ruangan berdasarkan nama
        if ($request->has('search')) {
            $query->where('nama_ruangan', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->paginate(10);
        return view('meeting_rooms.index', compact('rooms'));
    }

    // Form tambah ruangan
    public function create()
    {
        $categories = Category::all();
        return view('meeting_rooms.create', compact('categories'));
    }

    // Simpan ruangan baru
    public function store(StoreMeetingRoomRequest $request)
    {
        $room = MeetingRoom::create($request->validated());
        $room->categories()->sync($request->categories);
        return redirect()->route('meeting-rooms.index')->with('success', 'Ruangan berhasil ditambahkan');
    }

    // Form edit ruangan
    public function edit(MeetingRoom $meetingRoom)
    {
        $categories = Category::all();
        return view('meeting_rooms.edit', compact('meetingRoom', 'categories'));
    }

    // Update ruangan
    public function update(UpdateMeetingRoomRequest $request, MeetingRoom $meetingRoom)
    {
        $meetingRoom->update($request->validated());
        $meetingRoom->categories()->sync($request->categories);
        return redirect()->route('meeting-rooms.index')->with('success', 'Ruangan berhasil diperbarui');
    }

    // Hapus ruangan
    public function destroy(MeetingRoom $meetingRoom)
    {
        $meetingRoom->delete();
        return redirect()->route('meeting-rooms.index')->with('success', 'Ruangan berhasil dihapus');
    }
}