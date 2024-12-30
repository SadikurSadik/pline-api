<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerName = $this->faker->name();
        $city = City::with('state')->inRandomOrder()->first();

        return [
            'user_id' => function () use ($customerName) {
                $user = \App\Models\User::factory()->create([
                    'role_id' => Role::CUSTOMER->value,
                    'name' => $customerName,
                    'email' => $this->faker->safeEmail(),
                    'password' => 'password',
                    'status' => $this->faker->randomElement([1, 2]),
                ]);
                $user->syncRolePermissions();

                return $user->id;
            },
            'name' => $customerName,
            'customer_id' => random_int(10000, 999999),
            'company_name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'country_id' => data_get($city, 'state.country_id'),
            'state_id' => $city->state_id,
            'city_id' => $city->id,
            'address' => $this->faker->address(),
            'category' => fake()->randomElement(['A', 'B']),
        ];
    }
}
