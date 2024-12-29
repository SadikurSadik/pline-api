<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ports')->insert([
            [
                'country_id' => 231,
                'state_id' => 5,
                'name' => 'LOS ANGELES, CA',
                'status' => 1,
            ],
            [
                'country_id' => 231,
                'state_id' => 43,
                'name' => 'Houston, TX',
                'status' => 1,
            ],
            [
                'country_id' => 231,
                'state_id' => 10,
                'name' => 'SAVANNAH, GA',
                'status' => 1,
            ],
            [
                'country_id' => 231,
                'state_id' => 53,
                'name' => 'NEWARK, NJ',
                'status' => 1,
            ],
            [
                'country_id' => 229,
                'state_id' => 52,
                'name' => 'JEBEL ALI',
                'status' => 1,
            ],
            [
                'country_id' => 38,
                'state_id' => 54,
                'name' => 'TORONTO',
                'status' => 1,
            ],
            [
                'country_id' => 38,
                'state_id' => 55,
                'name' => 'MONTREAL',
                'status' => 1,
            ],
            [
                'country_id' => 38,
                'state_id' => 56,
                'name' => 'HALIFAX',
                'status' => 1,
            ],
            [
                'country_id' => 38,
                'state_id' => 57,
                'name' => 'EDMONTON',
                'status' => 1,
            ],
            [
                'country_id' => 38,
                'state_id' => 58,
                'name' => 'CALGARY',
                'status' => 1,
            ],
            [
                'country_id' => 1,
                'state_id' => 73,
                'name' => 'Islam Qalla',
                'status' => 1,
            ],
            [
                'country_id' => 1,
                'state_id' => 73,
                'name' => 'Islam Qalla',
                'status' => 1,
            ],
            [
                'country_id' => 224,
                'state_id' => 70,
                'name' => 'Ashgabat',
                'status' => 1,
            ],
            [
                'country_id' => 224,
                'state_id' => 71,
                'name' => 'Charjov',
                'status' => 1,
            ],
            [
                'country_id' => 224,
                'state_id' => 69,
                'name' => 'Mary',
                'status' => 1,
            ],
            [
                'country_id' => 224,
                'state_id' => 72,
                'name' => 'Sarakhs',
                'status' => 1,
            ],
            [
                'country_id' => 103,
                'state_id' => 75,
                'name' => 'Bandar Linga',
                'status' => 1,
            ],
            [
                'country_id' => 103,
                'state_id' => 74,
                'name' => 'Bandar Bas',
                'status' => 1,
            ],
            [
                'country_id' => 38,
                'state_id' => 76,
                'name' => 'VANCOUVER',
                'status' => 1,
            ],
            [
                'country_id' => 249,
                'state_id' => 78,
                'name' => 'KLAIPEDA',
                'status' => 1,
            ],
            [
                'country_id' => 38,
                'state_id' => 79,
                'name' => 'MANITOBA',
                'status' => 1,
            ],
            [
                'country_id' => 250,
                'state_id' => 80,
                'name' => 'UMM QASER',
                'status' => 1,
            ],
            [
                'country_id' => 252,
                'state_id' => 83,
                'name' => 'SOHAR',
                'status' => 1,
            ],
            [
                'country_id' => 251,
                'state_id' => 82,
                'name' => 'MERSIN',
                'status' => 1,
            ],
            [
                'country_id' => 252,
                'state_id' => 83,
                'name' => 'SOHAR',
                'status' => 1,
            ],
            [
                'country_id' => 253,
                'state_id' => 84,
                'name' => 'GERMANY',
                'status' => 1,
            ],
            [
                'country_id' => 81,
                'state_id' => 85,
                'name' => 'POTI',
                'status' => 1,
            ],
        ]);
    }
}
