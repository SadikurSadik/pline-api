<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complain>
 */
class ComplainFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_user_id' => Customer::inRandomOrder()->first()->value('user_id'),
            'subject' => fake()->paragraph(1),
            'message' => fake()->paragraph,
        ];
    }
}
