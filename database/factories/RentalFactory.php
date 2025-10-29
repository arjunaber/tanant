<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rental_code' => 'RENT-' . strtoupper(uniqid()),
            'user_id' => \App\Models\User::factory(),
            'unit_id' => \App\Models\Unit::factory(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'total_price' => $this->faker->numberBetween(50000, 250000),
            'purpose' => $this->faker->sentence(),
            'status' => 'active',
            'payment_status' => 'paid',
        ];
    }
}
