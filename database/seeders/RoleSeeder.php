<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Owner', 'guard_name' => 'web'],
            ['name' => 'Super Admin', 'guard_name' => 'web'],
            ['name' => 'Customer', 'guard_name' => 'web'],
            ['name' => 'Sub User', 'guard_name' => 'web'],
            ['name' => 'Data Entry', 'guard_name' => 'web'],
            ['name' => 'Viewer', 'guard_name' => 'web'],
            ['name' => 'Accountant', 'guard_name' => 'web'],
            ['name' => 'Admin', 'guard_name' => 'web'],
        ]);

        Role::find(1)->givePermissionTo(Permission::pluck('name')->toArray());
        Role::find(2)->givePermissionTo(Permission::where('name', 'not like', 'delete %')->pluck('name')->toArray());
        Role::find(3)->givePermissionTo([
            'manage user',
            'create user',
            'update user',
            'view user',
            'manage vehicle',
            'view vehicle',
            'manage container',
            'view container',
            'manage damage claim',
            'create damage claim',
            'update damage claim',
            'view damage claim',
            'manage complain',
            'create complain',
        ]);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
