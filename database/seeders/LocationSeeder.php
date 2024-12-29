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
                'name' => 'LA',
                'status' => 1,
            ],
            [
                'name' => 'GA',
                'status' => 1,
            ],
            [
                'name' => 'NY',
                'status' => 1,
            ],
            [
                'name' => 'TX',
                'status' => 1,
            ],
            [
                'name' => 'TX2',
                'status' => 2,
            ],
            [
                'name' => 'NJ2',
                'status' => 2,
            ],
            [
                'name' => 'CANADA',
                'status' => 2,
            ],
            [
                'name' => 'TORONTO',
                'status' => 1,
            ],
            [
                'name' => 'MONTREAL',
                'status' => 1,
            ],
            [
                'name' => 'HALIFAX',
                'status' => 1,
            ],
            [
                'name' => 'EDMONTON',
                'status' => 1,
            ],
            [
                'name' => 'CALGARY',
                'status' => 1,
            ],
            [
                'name' => 'Afghanistan',
                'status' => 1,
            ],
            [
                'name' => 'Tajikistan',
                'status' => 2,
            ],
            [
                'name' => 'Turkamanistan',
                'status' => 1,
            ],
            [
                'name' => 'Uzbekistan',
                'status' => 2,
            ],
            [
                'name' => 'Iraq',
                'status' => 2,
            ],
            [
                'name' => 'Iran',
                'status' => 2,
            ],
            [
                'name' => 'VANCOUVER',
                'status' => 1,
            ],
            [
                'name' => 'MANITOBA',
                'status' => 1,
            ],
            [
                'name' => 'WA',
                'status' => 2,
            ],
        ]);
    }
}
