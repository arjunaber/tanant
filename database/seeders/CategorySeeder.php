<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Meeting Room',
                'description' => 'Ruangan untuk meeting dan rapat'
            ],
            [
                'name' => 'Conference Hall',
                'description' => 'Aula besar untuk konferensi dan seminar'
            ],
            [
                'name' => 'Coworking Space',
                'description' => 'Ruang kerja bersama dengan fasilitas lengkap'
            ],
            [
                'name' => 'Private Office',
                'description' => 'Kantor pribadi dengan akses 24 jam'
            ],
            [
                'name' => 'Training Room',
                'description' => 'Ruangan khusus untuk pelatihan dan workshop'
            ],
            [
                'name' => 'Studio',
                'description' => 'Studio untuk fotografi, rekaman, atau produksi'
            ],
            [
                'name' => 'Event Space',
                'description' => 'Tempat untuk acara dan pesta'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
