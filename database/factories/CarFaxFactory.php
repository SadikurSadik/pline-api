<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFaxFactory extends Factory
{
    public function definition(): array
    {
        return [
            'requested_by' => Customer::query()->inRandomOrder()->first()?->user_id,
            'vin' => $this->faker->word,
            'lot_number' => $this->faker->randomNumber(),
            'year' => $this->faker->year,
            'make' => $this->faker->word,
            'model' => $this->faker->word,
            'color' => $this->faker->word,
            'status' => $this->faker->randomElement([1, 2]),
            'document_url' => $this->faker->imageUrl(),
            'note' => $this->faker->text,
        ];
    }
}
