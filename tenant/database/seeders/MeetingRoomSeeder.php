<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MeetingRoom;

class MeetingRoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['kode_ruangan' => 'R001', 'nama_ruangan' => 'Meeting Room A', 'deskripsi' => 'Kapasitas 10 orang'],
            ['kode_ruangan' => 'R002', 'nama_ruangan' => 'Meeting Room B', 'deskripsi' => 'Kapasitas 20 orang'],
            ['kode_ruangan' => 'R003', 'nama_ruangan' => 'VIP Meeting Room', 'deskripsi' => 'Kapasitas 5 orang, fasilitas premium'],
        ];

        foreach ($rooms as $room) {
            MeetingRoom::create($room);
        }
    }
}