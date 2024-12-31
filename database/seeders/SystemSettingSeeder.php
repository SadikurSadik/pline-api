<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('system_settings')->insert([
            ['name' => 'clearance_rate', 'value' => 300],
            ['name' => 'profit', 'value' => 100],
        ]);
    }
}
