<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('features')->insert([
            ['name' => "CD Changer"],
            ['name' => "GPS Navigation System"],
            ['name' => "Spare Tire/Jack"],
            ['name' => "Wheel Covers"],
            ['name' => "Radio"],
            ['name' => "CD Player"],
            ['name' => "Mirror"],
            ['name' => "Speaker"],
            ['name' => "Other..."],
        ]);
    }
}
