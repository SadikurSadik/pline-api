<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sheet>
 */
class SheetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'status' => fake()->randomElement([1,2])
        ];
    }
}
