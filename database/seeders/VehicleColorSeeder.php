<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_colors')->insert([
            ['name' => 'WHITE'],
            ['name' => 'BLACK'],
            ['name' => 'RED'],
            ['name' => 'BURGUNDY'],
            ['name' => 'SILVER'],
            ['name' => 'GRAY'],
            ['name' => 'BLUE'],
            ['name' => 'MAROON'],
            ['name' => 'TAN'],
            ['name' => 'TURQUOISE'],
            ['name' => 'CHARCOAL'],
            ['name' => 'DARK BLUE'],
            ['name' => 'BEIGE'],
            ['name' => 'CREAM'],
            ['name' => 'PURPLE'],
            ['name' => 'GREEN'],
            ['name' => 'GOLD'],
            ['name' => 'BROWN'],
            ['name' => 'YELLOW'],
            ['name' => 'ORANGE'],
            ['name' => 'TWO TONE'],
            ['name' => 'PEWTER'],
            ['name' => 'NAVY'],
            ['name' => 'Teal'],
            ['name' => 'Multi'],
            ['name' => 'LIGHT BLUE'],
            ['name' => 'Champagne'],
            ['name' => 'burn'],
            ['name' => 'Unknown'],
            ['name' => 'Blue0'],
            ['name' => 'Mahroon'],
            ['name' => 'CILVER'],
            ['name' => 'BLACKx'],
            ['name' => 'BURG'],
            ['name' => 'PINK'],
        ]);
    }
}
