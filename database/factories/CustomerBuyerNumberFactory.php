<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerBuyerNumber>
 */
class CustomerBuyerNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => rand(1,10),
            'buyer_number_id' => rand(1,30),
            'assigned_at' => now()->addHours(12),
            'unassigned_at' => now()
        ];
    }
}
