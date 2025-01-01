<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conditions')->insert([
            ['name' => 'FRONT WINDSHILED'],
            ['name' => 'BONNET'],
            ['name' => 'GRILL'],
            ['name' => 'FRONT BUMPER'],
            ['name' => 'FROTN HEAD LIGHT'],
            ['name' => 'REAR WINDSHIELD'],
            ['name' => 'TRUNK DOOR'],
            ['name' => 'REAR BUMPER'],
            ['name' => 'REAR BUMPER SUPPORT'],
            ['name' => 'TAIL LAMP'],
            ['name' => 'FRONT LEFT FENDER'],
            ['name' => 'LEFT FRONT DOOR'],
            ['name' => 'LEFT REAR DOOR'],
            ['name' => 'LEFT REAR FENDER'],
            ['name' => 'PILLAR'],
            ['name' => 'ROOF'],
            ['name' => 'RIGHT REAR FENDER'],
            ['name' => 'RIGHT REAR DOOR'],
            ['name' => 'RIGHT FRONT DOOR'],
            ['name' => 'FRONT RIGHT FENDER'],
            ['name' => 'FRONT TYRES'],
        ]);
    }
}
