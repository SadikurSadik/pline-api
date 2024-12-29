<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TitleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('title_types')->insert([
            ['id' => 1, 'name' => 'NO TITLE'],
            ['id' => 2, 'name' => 'PENDING TITLE'],
            ['id' => 3, 'name' => 'BOS TITLE'],
            ['id' => 4, 'name' => 'LIEN TITILE'],
            ['id' => 5, 'name' => 'CLEAN TITLE'],
            ['id' => 6, 'name' => 'DMV TITLE'],
            ['id' => 7, 'name' => 'JUNK TITLE'],
            ['id' => 8, 'name' => 'SALVAGE'],
            ['id' => 9, 'name' => 'Certificate of Distraction'],
            ['id' => 10, 'name' => 'Unfit'],
            ['id' => 11, 'name' => 'Burn'],
            ['id' => 12, 'name' => 'Nonerepairable'],
            ['id' => 13, 'name' => 'Parts Only'],
            ['id' => 14, 'name' => 'Rebuildable'],
            ['id' => 15, 'name' => 'Water Flood'],
            ['id' => 16, 'name' => 'MV-907A(Newyork)'],
            ['id' => 17, 'name' => 'SCRAP TITLE'],
        ]);
    }
}
