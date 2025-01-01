<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Port;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContainerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_user_id' => Customer::inRandomOrder()->value('user_id'),
            'booking_number' => $this->generateBookingNumber(),
            'container_number' => random_int(1000000, 99999999),
            'seal_number' => fake()->randomNumber(),
            'vessel' => fake()->name,
            'voyage' => fake()->name,
            'streamship_line' => fake()->randomElement(
                [
                    'MAERSK',
                    'MSC',
                    'SAFMARINE',
                    'OOCL',
                    'ONE',
                    'EVERGREEN',
                    'YANG MING',
                    'HMM',
                    'PIL',
                    'APL',
                    'APM TERMINALS',
                    'CMA CGM',
                    'COSCO',
                    'HAPAG LLOYD',
                    'SEALAND',
                    'MEDITERRANEAN',
                ]
            ),
            'xtn_number' => random_int(1000, 99999),
            'itn' => random_int(100, 999999),
            'broker_name' => fake()->name,
            'oti_number' => random_int(10000, 99999),
            'terminal' => fake()->randomElement(['TORONTO', 'TX', 'NY', 'NJ', 'LA']),
            'destination' => 'JEBEL ALI',
            'ar_number' => $this->generateBookingNumber(),
            'loading_date' => fake()->date,
            'cut_off_date' => fake()->date,
            'export_date' => fake()->date,
            'eta_date' => fake()->date,
            'contact_detail' => fake()->paragraph,
            'port_of_loading_id' => Port::inRandomOrder()->value('id'),
            'port_of_discharge_id' => Port::inRandomOrder()->value('id'),
            'container_type' => fake()->randomElement([1, 2, 3]),
            'status' => fake()->randomElement([3, 8, 10, 15]),
        ];
    }

    private function generateBookingNumber()
    {
        return 'EMCU'.random_int(1000000, 9999999);
    }
}
