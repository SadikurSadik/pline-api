<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ['name' => 'UNITED STATES', 'short_code' => 'USA', 'status' => 1],
            ['name' => 'CANADA', 'short_code' => 'CN', 'status' => 1],
            ['name' => 'UNITED ARAB EMIRATES', 'short_code' => 'UAE', 'status' => 1],
            ['name' => 'TURKMANISTAN', 'short_code' => 'TURK', 'status' => 1],
            ['name' => 'BAHRAIN', 'short_code' => 'BHR', 'status' => 1],
            ['name' => 'MUSCAT', 'short_code' => 'OMN', 'status' => 1],
            ['name' => 'Baltimore,MD', 'short_code' => 'BA', 'status' => 1],
            ['name' => 'Sultanate of Oman', 'short_code' => 'Oman', 'status' => 1],
        ]);
    }
}
