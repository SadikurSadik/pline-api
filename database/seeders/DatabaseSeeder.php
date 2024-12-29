<?php

namespace Database\Seeders;

use App\Enums\Enums\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        User::factory(10)->create();

        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
        ]);
    }
}
