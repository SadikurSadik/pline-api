<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'country_id' => 1,
                'state_id' => 11,
                'name' => 'GA',
            ],
            [
                'country_id' => 1,
                'state_id' => 35,
                'name' => 'NY',
            ],
            [
                'country_id' => 1,
                'state_id' => 45,
                'name' => 'TX',
            ],
            [
                'country_id' => 1,
                'state_id' => 6,
                'name' => 'CA',
            ],
            [
                'country_id' => 2,
                'state_id' => 56,
                'name' => 'ON',
            ],
            [
                'country_id' => 2,
                'state_id' => 57,
                'name' => 'QC',
            ],
            [
                'country_id' => 2,
                'state_id' => 63,
                'name' => 'NS',
            ],
            [
                'country_id' => 2,
                'state_id' => 58,
                'name' => 'MB',
            ],
            [
                'country_id' => 2,
                'state_id' => 60,
                'name' => 'AB',
            ],
            [
                'country_id' => 2,
                'state_id' => 61,
                'name' => 'BC',
            ],
            [
                'country_id' => 3,
                'state_id' => 53,
                'name' => 'DXB',
            ],
            [
                'country_id' => 2,
                'state_id' => 60,
                'name' => 'AB',
            ],
            [
                'country_id' => 2,
                'state_id' => 59,
                'name' => 'SK',
            ],
            [
                'country_id' => 5,
                'state_id' => 78,
                'name' => 'BHR',
            ],
        ]);
    }
}
