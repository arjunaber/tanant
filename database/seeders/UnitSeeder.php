<?php
// database/seeders/UnitSeeder.php
namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Category;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            [
                'code' => 'MR-001',
                'name' => 'Meeting Room A',
                'description' => 'Ruangan meeting kecil untuk 4-6 orang, dilengkapi dengan LCD projector dan whiteboard',
                'price_per_day' => 250000,
                'capacity' => 6,
                'facilities' => 'AC, LCD Projector, Whiteboard, WiFi, Meja dan Kursi',
                'categories' => [1, 5] // Meeting Room, Training Room
            ],
            [
                'code' => 'MR-002',
                'name' => 'Meeting Room B',
                'description' => 'Ruangan meeting medium untuk 8-10 orang, dengan view kota',
                'price_per_day' => 350000,
                'capacity' => 10,
                'facilities' => 'AC, Smart TV, Whiteboard, WiFi, Meja Rapat, Kitchenette',
                'categories' => [1]
            ],
            [
                'code' => 'CH-001',
                'name' => 'Conference Hall X',
                'description' => 'Aula konferensi besar dengan kapasitas hingga 100 orang',
                'price_per_day' => 1500000,
                'capacity' => 100,
                'facilities' => 'AC, Sound System, 2x LCD Projector, Stage, Lighting, WiFi',
                'categories' => [2, 7]
            ],
            [
                'code' => 'CH-002',
                'name' => 'Conference Hall Y',
                'description' => 'Aula konferensi medium untuk 50 orang',
                'price_per_day' => 800000,
                'capacity' => 50,
                'facilities' => 'AC, Sound System, LCD Projector, WiFi, Podium',
                'categories' => [2]
            ],
            [
                'code' => 'CS-001',
                'name' => 'Coworking Space Premium',
                'description' => 'Ruang kerja bersama dengan meja dedicated dan locker',
                'price_per_day' => 150000,
                'capacity' => 20,
                'facilities' => 'AC, High-speed WiFi, Printer/Scanner, Coffee Machine, Lounge Area',
                'categories' => [3]
            ],
            [
                'code' => 'PO-001',
                'name' => 'Private Office A',
                'description' => 'Kantor pribadi kecil untuk 2-3 orang',
                'price_per_day' => 500000,
                'capacity' => 3,
                'facilities' => 'AC, WiFi, Meja Kerja, Kursi, Cabinet, 24/7 Access',
                'categories' => [4]
            ],
            [
                'code' => 'PO-002',
                'name' => 'Private Office B',
                'description' => 'Kantor pribadi medium untuk 4-6 orang',
                'price_per_day' => 750000,
                'capacity' => 6,
                'facilities' => 'AC, WiFi, Meja Kerja, Kursi, Cabinet, Meeting Table, 24/7 Access',
                'categories' => [4]
            ],
            [
                'code' => 'TR-001',
                'name' => 'Training Room Alpha',
                'description' => 'Ruangan training dengan setup classroom',
                'price_per_day' => 600000,
                'capacity' => 25,
                'facilities' => 'AC, LCD Projector, Whiteboard, WiFi, Meja dan Kursi Training, Sound System',
                'categories' => [5]
            ],
            [
                'code' => 'ST-001',
                'name' => 'Photo Studio',
                'description' => 'Studio foto profesional dengan lighting equipment',
                'price_per_day' => 800000,
                'capacity' => 10,
                'facilities' => 'AC, Backdrop, Lighting Equipment, Changing Room, WiFi',
                'categories' => [6]
            ],
            [
                'code' => 'ES-001',
                'name' => 'Event Space Garden',
                'description' => 'Outdoor space untuk acara dan gathering',
                'price_per_day' => 1200000,
                'capacity' => 150,
                'facilities' => 'Garden Area, Sound System, Lighting, Power Outlets, Tent',
                'categories' => [7]
            ],
        ];

        foreach ($units as $index => $unitData) {
            $categories = $unitData['categories'];
            unset($unitData['categories']);

            // Make first unit occupied, rest available
            $unitData['status'] = ($index === 0) ? 'occupied' : 'available';

            $unit = Unit::create($unitData);
            $unit->categories()->attach($categories);
        }
    }
}
