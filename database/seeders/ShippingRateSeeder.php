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
                "amount" => 4400,
                "amount_40feet" => 4400,
                "amount_45feet" => 4400,
                "from_country_id" => 1,
                "from_state_id" => 11,
                "from_yard_id" => 1,
                "from_port_id" => 1,
                "to_country_id" => 3,
                "to_state_id" => 53,
                "to_yard_id" => 12,
                "to_port_id" => 11,
            ],
            [
                "amount" => 4500,
                "amount_40feet" => 4500,
                "amount_45feet" => 4500,
                "from_country_id" => 1,
                "from_state_id" => 35,
                "from_yard_id" => 2,
                "from_port_id" => 2,
                "to_country_id" => 3,
                "to_state_id" => 53,
                "to_yard_id" => 12,
                "to_port_id" => 11,
            ],
            [
                "amount" => 4500,
                "amount_40feet" => 4500,
                "amount_45feet" => 4500,
                "from_country_id" => 1,
                "from_state_id" => 45,
                "from_yard_id" => 3,
                "from_port_id" => 3,
                "to_country_id" => 3,
                "to_state_id" => 53,
                "to_yard_id" => 12,
                "to_port_id" => 11,
            ],
            [
                "amount" => 5300,
                "amount_40feet" => 5300,
                "amount_45feet" => 5300,
                "from_country_id" => 1,
                "from_state_id" => 6,
                "from_yard_id" => 4,
                "from_port_id" => 4,
                "to_country_id" => 3,
                "to_state_id" => 53,
                "to_yard_id" => 12,
                "to_port_id" => 11,
            ],
            [
                "amount" => 7000,
                "amount_40feet" => 5600,
                "amount_45feet" => 6000,
                "from_country_id" => 1,
                "from_state_id" => 49,
                "from_yard_id" => 5,
                "from_port_id" => 5,
                "to_country_id" => 3,
                "to_state_id" => 53,
                "to_yard_id" => 12,
                "to_port_id" => 11,
            ],
        ]);
    }
}
