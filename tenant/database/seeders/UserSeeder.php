<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Tenant',
            'email' => 'admin@tenant.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Samuel Arjuna',
            'email' => 'user1@tenant.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Cendekia',
            'email' => 'user2@tenant.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
