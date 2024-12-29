<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'developer@plineshipping.com'],
            [
                'role_id' => Role::OWNER->value,
                'name' => 'Developer Admin',
                'email' => 'developer@plineshipping.com',
                'username' => 'dev@ignition',
                'password' => Hash::make('secret'),
            ]
        );

        $this->call([
            ModuleSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            LocationSeeder::class,
            PortSeeder::class,
            TitleTypeSeeder::class,
        ]);

        User::factory(10)->create();
    }
}
