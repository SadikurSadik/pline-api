<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consignee>
 */
class ConsigneeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = City::with('state.country')->inRandomOrder()->first();
        return [
            'customer_user_id' => fake()->numberBetween(12, 21),
            'name' => fake()->name,
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'country_id' => $city->state->country->id,
            'state_id' => $city->state->id,
            'city_id' => $city->id,
        ];
    }
}
