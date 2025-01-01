<?php

namespace Database\Factories;

use App\Models\Vcc;
use Illuminate\Database\Eloquent\Factories\Factory;

class VccExitPaperFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vcc_id' => Vcc::query()->inRandomOrder()->first()->id,
            'received_date' => now(),
            'refund_amount' => rand(100, 9999),
            'status' => fake()->randomElement([1, 3, 4, 5, 6, 7, 8, 10]),
            'submission_date' => now(),
            'custom_duty_amount' => rand(100, 9999),
            'receivable_claim_amount' => rand(100, 9999),
            'amount_received_in_bank' => rand(100, 9999),
            'date_amount_received_in_bank' => now(),
            'received_from' => fake()->name,
            'received_by' => 1,
            'received_at' => now(),
            'submitted_by' => 1,
            'submitted_at' => now(),
        ];
    }
}
