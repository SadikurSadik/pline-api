<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class DamageClaimFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement([1, 2, 3]);

        return [
            'vehicle_id' => random_int(1, 30),
            'customer_user_id' => Customer::query()->inRandomOrder()->value('user_id'),
            'claim_amount' => random_int(50, 5000),
            'approved_amount' => $status === 2 ? random_int(50, 5000) : null,
            'description' => $this->faker->text(),
            'note' => $this->faker->text(),
            'photos' => [$this->faker->imageUrl(), $this->faker->imageUrl()],
            'status' => $status,
            'approve_reject_by' => in_array($status, [2, 3]) ? $this->faker->randomNumber() : null,
            'approve_reject_at' => in_array($status, [2, 3]) ? $this->faker->dateTime() : null,
        ];
    }
}
