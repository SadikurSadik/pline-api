<?php

namespace Database\Factories;

use App\Models\Container;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vcc>
 */
class VccFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::query()->inRandomOrder()->first()->id,
            'container_id' => Container::query()->inRandomOrder()->first()->id,
            'shipping_invoice_id' => 1,
            'declaration_number' => rand(0000000000000, 9999999999999),
            'declaration_date' => now(),
            'received_date' => now(),
            'custom_duty' => rand(100, 9999),
            'expire_date' => now()->addDays(30),
            'status' => fake()->randomElement([1, 3, 4, 5, 6, 7, 8, 10]),
            'deposit_amount' => rand(100, 5000),
            'handed_over_to' => fake()->name,
            'vehicle_registration_type' => random_int(1, 3),
            'issued_by' => 1,
            'issued_at' => now(),
            'handed_over_by' => 1,
            'handed_over_at' => now(),
            'container_bg_color' => fake()->colorName,
            'vcc_attachment' => null,
            'bill_of_entry_attachment' => null,
            'other_attachment' => null,
        ];
    }
}
