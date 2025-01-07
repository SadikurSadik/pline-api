<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert([
            ['name' => 'Roles'],
            ['name' => 'User Management'],
            ['name' => 'Country'],
            ['name' => 'State'],
            ['name' => 'City'],
            ['name' => 'Location'],
            ['name' => 'Port'],
            ['name' => 'Title Type'],
            ['name' => 'Customer'],
            ['name' => 'Consignee'],
            ['name' => 'Towing Rate'],
            ['name' => 'Shipping Rate'],
            ['name' => 'Clearance Rate'],
            ['name' => 'Vehicle'],
            ['name' => 'Container'],
            ['name' => 'Damage Claim'],
            ['name' => 'VCC'],
            ['name' => 'Complain'],
        ]);
    }
}
