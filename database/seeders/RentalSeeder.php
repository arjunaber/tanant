<?php
// database/seeders/RentalSeeder.php
namespace Database\Seeders;

use App\Models\Rental;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'user')->get();
        $units = Unit::all();

        // Create some active rentals
        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $unit = $units->random();

            // Check if user already has 2 active rentals
            $activeRentals = Rental::where('user_id', $user->id)
                ->whereIn('status', ['active', 'overdue'])
                ->count();

            if ($activeRentals < 2) {
                Rental::create([
                    'rental_code' => 'RENT-' . strtoupper(uniqid()),
                    'user_id' => $user->id,
                    'unit_id' => $unit->id,
                    'start_date' => now()->subDays(rand(1, 3)),
                    'end_date' => now()->addDays(rand(1, 5)),
                    'total_price' => $unit->price_per_day * rand(1, 5),
                    'status' => 'active',
                    'purpose' => $this->getRandomPurpose(),
                ]);

                // Update unit status to occupied
                $unit->update(['status' => 'occupied']);
            }
        }

        // Create some completed rentals
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $unit = $units->random();
            $startDate = now()->subDays(rand(10, 30));
            $endDate = $startDate->copy()->addDays(rand(1, 5));
            $returnDate = $endDate->copy()->addHours(rand(1, 12));

            Rental::create([
                'rental_code' => 'RENT-' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'unit_id' => $unit->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'return_date' => $returnDate,
                'total_price' => $unit->price_per_day * $endDate->diffInDays($startDate),
                'status' => 'completed',
                'purpose' => $this->getRandomPurpose(),
                'processed_by' => User::where('role', 'admin')->first()->id,
            ]);
        }

        // Create some overdue rentals
        for ($i = 0; $i < 2; $i++) {
            $user = $users->random();
            $unit = $units->random();

            $activeRentals = Rental::where('user_id', $user->id)
                ->whereIn('status', ['active', 'overdue'])
                ->count();

            if ($activeRentals < 2) {
                $startDate = now()->subDays(6); // Already overdue
                $endDate = now()->subDays(1);

                Rental::create([
                    'rental_code' => 'RENT-' . strtoupper(uniqid()),
                    'user_id' => $user->id,
                    'unit_id' => $unit->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_price' => $unit->price_per_day * $endDate->diffInDays($startDate),
                    'late_fee' => $unit->price_per_day * 0.2 * 1, // 20% per day
                    'status' => 'overdue',
                    'purpose' => $this->getRandomPurpose(),
                ]);

                // Update unit status to occupied
                $unit->update(['status' => 'occupied']);
            }
        }
    }

    private function getRandomPurpose()
    {
        $purposes = [
            'Meeting dengan klien',
            'Training karyawan',
            'Workshop dan seminar',
            'Rapat internal tim',
            'Event perusahaan',
            'Photo shoot produk',
            'Konferensi pers',
            'Presentasi kepada investor',
            'Team building',
            'Interview dan rekrutmen',
        ];

        return $purposes[array_rand($purposes)];
    }
}
