<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Complain;
use App\Models\Consignee;
use App\Models\Container;
use App\Models\Customer;
use App\Models\DamageClaim;
use App\Models\User;
use App\Models\Vcc;
use App\Models\VccExitPaper;
use App\Models\Vehicle;
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

        $adminUser = User::updateOrCreate(
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
            SystemSettingSeeder::class,
            TowingRateSeeder::class,
            ShippingRateSeeder::class,
            VehicleColorSeeder::class,
            ConditionSeeder::class,
            FeatureSeeder::class,
            PricingPdfSeeder::class,
        ]);

        $adminUser->syncRolePermissions();

        User::factory(10)->create();
        Customer::factory(10)->create();
        Consignee::factory(10)->create();
        Vehicle::factory(50)->create();
        Container::factory(20)->create();
        DamageClaim::factory(20)->create();
        Vcc::factory(20)->create();
        Complain::factory(10)->create();
        //VccExitPaper::factory(20)->create();
    }
}
