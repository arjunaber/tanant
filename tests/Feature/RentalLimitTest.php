<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Unit;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RentalLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_rent_maximum_two_units()
    {
        // Create a user
        $user = User::factory()->create();

        // Create available units
        $unit1 = Unit::factory()->create(['status' => 'available']);
        $unit2 = Unit::factory()->create(['status' => 'available']);
        $unit3 = Unit::factory()->create(['status' => 'available']);

        // Create two active rentals for the user
        Rental::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit1->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays(3),
        ]);

        Rental::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit2->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays(3),
        ]);

        // Act as the user
        $this->actingAs($user);

        // Attempt to create a rental for the third unit
        $response = $this->get(route('rentals.create', $unit3->id));

        // Assert that the user is redirected with an error message
        $response->assertRedirect(route('units.show', $unit3->id));
        $response->assertSessionHas('error', 'Anda sudah meminjam 2 unit. Tidak bisa meminjam lagi.');
    }

    public function test_user_can_rent_when_has_less_than_two_active_rentals()
    {
        // Create a user
        $user = User::factory()->create();

        // Create available units
        $unit1 = Unit::factory()->create(['status' => 'available']);
        $unit2 = Unit::factory()->create(['status' => 'available']);

        // Create one active rental for the user
        Rental::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit1->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays(3),
        ]);

        // Act as the user
        $this->actingAs($user);

        // Attempt to create a rental for the second unit
        $response = $this->get(route('rentals.create', $unit2->id));

        // Assert that the user can access the rental creation page
        $response->assertStatus(200);
        $response->assertViewIs('rentals.create');
    }

    public function test_overdue_rentals_count_towards_limit()
    {
        // Create a user
        $user = User::factory()->create();

        // Create available units
        $unit1 = Unit::factory()->create(['status' => 'available']);
        $unit2 = Unit::factory()->create(['status' => 'available']);
        $unit3 = Unit::factory()->create(['status' => 'available']);

        // Create two overdue rentals for the user
        Rental::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit1->id,
            'status' => 'overdue',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(5),
        ]);

        Rental::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit2->id,
            'status' => 'overdue',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(5),
        ]);

        // Act as the user
        $this->actingAs($user);

        // Attempt to create a rental for the third unit
        $response = $this->get(route('rentals.create', $unit3->id));

        // Assert that the user is redirected with an error message
        $response->assertRedirect(route('units.show', $unit3->id));
        $response->assertSessionHas('error', 'Anda sudah meminjam 2 unit. Tidak bisa meminjam lagi.');
    }

    public function test_completed_rentals_do_not_count_towards_limit()
    {
        // Create a user
        $user = User::factory()->create();

        // Create available units
        $unit1 = Unit::factory()->create(['status' => 'available']);
        $unit2 = Unit::factory()->create(['status' => 'available']);
        $unit3 = Unit::factory()->create(['status' => 'available']);

        // Create two completed rentals for the user
        Rental::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit1->id,
            'status' => 'completed',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(5),
            'return_date' => now()->subDays(4),
        ]);

        Rental::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit2->id,
            'status' => 'completed',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(5),
            'return_date' => now()->subDays(4),
        ]);

        // Act as the user
        $this->actingAs($user);

        // Attempt to create a rental for the third unit
        $response = $this->get(route('rentals.create', $unit3->id));

        // Assert that the user can access the rental creation page
        $response->assertStatus(200);
        $response->assertViewIs('rentals.create');
    }
}
