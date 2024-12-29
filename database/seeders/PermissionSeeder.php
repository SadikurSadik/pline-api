<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            // role module
            ['name' => 'manage role', 'module_id' => 1, 'guard_name' => 'web'],
            ['name' => 'update role', 'module_id' => 1, 'guard_name' => 'web'],

            // user module
            ['name' => 'manage user', 'module_id' => 2, 'guard_name' => 'web'],
            ['name' => 'create user', 'module_id' => 2, 'guard_name' => 'web'],
            ['name' => 'update user', 'module_id' => 2, 'guard_name' => 'web'],
            ['name' => 'view user', 'module_id' => 2, 'guard_name' => 'web'],
            ['name' => 'delete user', 'module_id' => 2, 'guard_name' => 'web'],
            ['name' => 'export excel user', 'module_id' => 2, 'guard_name' => 'web'],

            // country module
            ['name' => 'manage country', 'module_id' => 3, 'guard_name' => 'web'],
            ['name' => 'create country', 'module_id' => 3, 'guard_name' => 'web'],
            ['name' => 'update country', 'module_id' => 3, 'guard_name' => 'web'],
            ['name' => 'view country', 'module_id' => 3, 'guard_name' => 'web'],
            ['name' => 'delete country', 'module_id' => 3, 'guard_name' => 'web'],
            ['name' => 'export excel country', 'module_id' => 3, 'guard_name' => 'web'],

            // state module
            ['name' => 'manage state', 'module_id' => 4, 'guard_name' => 'web'],
            ['name' => 'create state', 'module_id' => 4, 'guard_name' => 'web'],
            ['name' => 'update state', 'module_id' => 4, 'guard_name' => 'web'],
            ['name' => 'view state', 'module_id' => 4, 'guard_name' => 'web'],
            ['name' => 'delete state', 'module_id' => 4, 'guard_name' => 'web'],
            ['name' => 'export excel state', 'module_id' => 4, 'guard_name' => 'web'],

            // city module
            ['name' => 'manage city', 'module_id' => 5, 'guard_name' => 'web'],
            ['name' => 'create city', 'module_id' => 5, 'guard_name' => 'web'],
            ['name' => 'update city', 'module_id' => 5, 'guard_name' => 'web'],
            ['name' => 'view city', 'module_id' => 5, 'guard_name' => 'web'],
            ['name' => 'delete city', 'module_id' => 5, 'guard_name' => 'web'],
            ['name' => 'export excel city', 'module_id' => 5, 'guard_name' => 'web'],

            // location module
            ['name' => 'manage location', 'module_id' => 6, 'guard_name' => 'web'],
            ['name' => 'create location', 'module_id' => 6, 'guard_name' => 'web'],
            ['name' => 'update location', 'module_id' => 6, 'guard_name' => 'web'],
            ['name' => 'view location', 'module_id' => 6, 'guard_name' => 'web'],
            ['name' => 'delete location', 'module_id' => 6, 'guard_name' => 'web'],
            ['name' => 'export excel location', 'module_id' => 6, 'guard_name' => 'web'],

            // port module
            ['name' => 'manage port', 'module_id' => 7, 'guard_name' => 'web'],
            ['name' => 'create port', 'module_id' => 7, 'guard_name' => 'web'],
            ['name' => 'update port', 'module_id' => 7, 'guard_name' => 'web'],
            ['name' => 'view port', 'module_id' => 7, 'guard_name' => 'web'],
            ['name' => 'delete port', 'module_id' => 7, 'guard_name' => 'web'],
            ['name' => 'export excel port', 'module_id' => 7, 'guard_name' => 'web'],

            // title type module
            ['name' => 'manage title type', 'module_id' => 8, 'guard_name' => 'web'],
            ['name' => 'create title type', 'module_id' => 8, 'guard_name' => 'web'],
            ['name' => 'update title type', 'module_id' => 8, 'guard_name' => 'web'],
            ['name' => 'view title type', 'module_id' => 8, 'guard_name' => 'web'],
            ['name' => 'delete title type', 'module_id' => 8, 'guard_name' => 'web'],
            ['name' => 'export excel title type', 'module_id' => 8, 'guard_name' => 'web'],

            // customer module
            ['name' => 'manage customer', 'module_id' => 9, 'guard_name' => 'web'],
            ['name' => 'create customer', 'module_id' => 9, 'guard_name' => 'web'],
            ['name' => 'update customer', 'module_id' => 9, 'guard_name' => 'web'],
            ['name' => 'view customer', 'module_id' => 9, 'guard_name' => 'web'],
            ['name' => 'delete customer', 'module_id' => 9, 'guard_name' => 'web'],
            ['name' => 'export excel customer', 'module_id' => 9, 'guard_name' => 'web'],

            // consignee module
            ['name' => 'manage consignee', 'module_id' => 10, 'guard_name' => 'web'],
            ['name' => 'create consignee', 'module_id' => 10, 'guard_name' => 'web'],
            ['name' => 'update consignee', 'module_id' => 10, 'guard_name' => 'web'],
            ['name' => 'view consignee', 'module_id' => 10, 'guard_name' => 'web'],
            ['name' => 'delete consignee', 'module_id' => 10, 'guard_name' => 'web'],
            ['name' => 'export excel consignee', 'module_id' => 10, 'guard_name' => 'web'],

            // consignee module
            ['name' => 'manage towing rate', 'module_id' => 11, 'guard_name' => 'web'],
            ['name' => 'create towing rate', 'module_id' => 11, 'guard_name' => 'web'],
            ['name' => 'update towing rate', 'module_id' => 11, 'guard_name' => 'web'],
            ['name' => 'view towing rate', 'module_id' => 11, 'guard_name' => 'web'],
            ['name' => 'delete towing rate', 'module_id' => 11, 'guard_name' => 'web'],
            ['name' => 'export excel towing rate', 'module_id' => 11, 'guard_name' => 'web'],

            // shipping rate module
            ['name' => 'manage shipping rate', 'module_id' => 12, 'guard_name' => 'web'],
            ['name' => 'create shipping rate', 'module_id' => 12, 'guard_name' => 'web'],
            ['name' => 'update shipping rate', 'module_id' => 12, 'guard_name' => 'web'],
            ['name' => 'view shipping rate', 'module_id' => 12, 'guard_name' => 'web'],
            ['name' => 'delete shipping rate', 'module_id' => 12, 'guard_name' => 'web'],
            ['name' => 'export excel shipping rate', 'module_id' => 12, 'guard_name' => 'web'],

            // clearance rate module
            ['name' => 'manage clearance rate', 'module_id' => 13, 'guard_name' => 'web'],
            ['name' => 'update clearance rate', 'module_id' => 13, 'guard_name' => 'web'],

            // vehicle module
            ['name' => 'manage vehicle', 'module_id' => 14, 'guard_name' => 'web'],
            ['name' => 'create vehicle', 'module_id' => 14, 'guard_name' => 'web'],
            ['name' => 'update vehicle', 'module_id' => 14, 'guard_name' => 'web'],
            ['name' => 'view vehicle', 'module_id' => 14, 'guard_name' => 'web'],
            ['name' => 'delete vehicle', 'module_id' => 14, 'guard_name' => 'web'],
            ['name' => 'export excel vehicle', 'module_id' => 14, 'guard_name' => 'web'],

            // container module
            ['name' => 'manage container', 'module_id' => 15, 'guard_name' => 'web'],
            ['name' => 'create container', 'module_id' => 15, 'guard_name' => 'web'],
            ['name' => 'update container', 'module_id' => 15, 'guard_name' => 'web'],
            ['name' => 'view container', 'module_id' => 15, 'guard_name' => 'web'],
            ['name' => 'delete container', 'module_id' => 15, 'guard_name' => 'web'],
            ['name' => 'export excel container', 'module_id' => 15, 'guard_name' => 'web'],

            // damage claim module
            ['name' => 'manage damage claim', 'module_id' => 16, 'guard_name' => 'web'],
            ['name' => 'create damage claim', 'module_id' => 16, 'guard_name' => 'web'],
            ['name' => 'update damage claim', 'module_id' => 16, 'guard_name' => 'web'],
            ['name' => 'view damage claim', 'module_id' => 16, 'guard_name' => 'web'],
            ['name' => 'delete damage claim', 'module_id' => 16, 'guard_name' => 'web'],
            ['name' => 'export excel damage claim', 'module_id' => 16, 'guard_name' => 'web'],
        ]);
    }
}
