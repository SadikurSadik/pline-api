<?php

namespace Database\Factories;

use App\Models\Sheet;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuyerNumber>
 */
class BuyerNumberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sheet_id' => Sheet::query()->inRandomOrder()->first()->id,
            'buyer_id' => fake()->randomElement(['124740', '125859', '128609', '131574', '133289', '13529', '14852', '150108', '150931', '152131', '154457', '154479', '154825', '15707', '160253', '160360', '162939', '1653032', '168919', '169162', '174046', '174643', '176108', '176328', '177534', '182682', '182849', '190839', '191657']),
            'username' => fake()->userName,
            'password' => fake()->password,
            'auction_name' => Vehicle::query()->inRandomOrder()->first()->auction_name,
            'account_name' => fake()->name,
            'company_name' => fake()->company,
            'grade_id' => rand(1,30),
            'note' => fake()->paragraph,
            'attachments' => '',
            'status' => rand(1,2),
        ];
    }
}
