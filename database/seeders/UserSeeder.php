<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Tenant',
            'email' => 'admin@tenant.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $admin->id,
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Jakarta',
            'identity_number' => '1234567890123456',
        ]);

        // Create Regular Users
        $users = [
            [
                'name' => 'User Satu',
                'email' => 'user1@tenant.com',
                'phone' => '081234567891',
                'address' => 'Jl. User No. 1, Jakarta',
                'identity_number' => '1234567890123457',
            ],
            [
                'name' => 'User Dua',
                'email' => 'user2@tenant.com',
                'phone' => '081234567892',
                'address' => 'Jl. User No. 2, Jakarta',
                'identity_number' => '1234567890123458',
            ],
            [
                'name' => 'User Tiga',
                'email' => 'user3@tenant.com',
                'phone' => '081234567893',
                'address' => 'Jl. User No. 3, Jakarta',
                'identity_number' => '1234567890123459',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'phone' => $userData['phone'],
                'address' => $userData['address'],
                'identity_number' => $userData['identity_number'],
            ]);
        }

        // Create additional 7 users
        for ($i = 4; $i <= 10; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@tenant.com",
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'phone' => '0812345678' . (90 + $i),
                'address' => "Jl. User No. $i, Jakarta",
                'identity_number' => '1234567890123' . (450 + $i),
            ]);
        }
    }
}