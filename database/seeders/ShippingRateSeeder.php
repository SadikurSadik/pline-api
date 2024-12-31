<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shipping_rates')->insert([
            [
                'amount' => 2700,
                'amount_40feet' => 2358,
                'amount_45feet' => 2658,
                'from_country_id' => 231,
                'from_state_id' => 5,
                'from_port_id' => 1,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 1800,
                'amount_40feet' => 1800,
                'amount_45feet' => 2000,
                'from_country_id' => 231,
                'from_state_id' => 10,
                'from_port_id' => 3,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 2200,
                'amount_40feet' => 2200,
                'amount_45feet' => 2500,
                'from_country_id' => 231,
                'from_state_id' => 43,
                'from_port_id' => 2,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 1800,
                'amount_40feet' => 1800,
                'amount_45feet' => 2000,
                'from_country_id' => 231,
                'from_state_id' => 53,
                'from_port_id' => 4,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 1000,
                'amount_40feet' => 700,
                'amount_45feet' => 900,
                'from_country_id' => 229,
                'from_state_id' => 52,
                'from_port_id' => 5,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 2200,
                'amount_40feet' => 2200,
                'amount_45feet' => 2200,
                'from_country_id' => 38,
                'from_state_id' => 57,
                'from_port_id' => 9,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 2500,
                'amount_40feet' => 2500,
                'amount_45feet' => 2700,
                'from_country_id' => 38,
                'from_state_id' => 58,
                'from_port_id' => 10,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 3200,
                'amount_40feet' => 3200,
                'amount_45feet' => 3200,
                'from_country_id' => 38,
                'from_state_id' => 76,
                'from_port_id' => 20,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 3200,
                'amount_40feet' => 3200,
                'amount_45feet' => 3200,
                'from_country_id' => 38,
                'from_state_id' => 56,
                'from_port_id' => 8,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 2600,
                'amount_40feet' => 2600,
                'amount_45feet' => 2800,
                'from_country_id' => 38,
                'from_state_id' => 54,
                'from_port_id' => 6,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
            [
                'amount' => 2800,
                'amount_40feet' => 2800,
                'amount_45feet' => 3200,
                'from_country_id' => 38,
                'from_state_id' => 55,
                'from_port_id' => 7,
                'to_country_id' => 229,
                'to_state_id' => 52,
                'to_port_id' => 5,
            ],
        ]);
    }
}
