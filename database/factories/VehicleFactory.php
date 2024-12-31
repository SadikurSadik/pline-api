<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Customer;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    public function definition(): array
    {
        $city = City::with('state')
            ->inRandomOrder()
            ->first();

        return [
            'customer_user_id' => Customer::inRandomOrder()->value('user_id'),
            'year' => fake()->year,
            'make' => fake()->name,
            'model' => fake()->name,
            'color' => fake()->colorName,
            'vin_number' => $this->generateVin(),
            'lot_number' => random_int(10000, 999999),
            'value' => random_int(500, 10000),
            'service_provider' => fake()->randomElement(['NJ', 'SAHIB', 'ATLANTIC', 'NEJOUM', 'MKL', 'CANADA','PGL']),
            'auction_name' => fake()->randomElement(['COPART', 'IAAI', 'BROKER', 'AUTOBID MASTER', 'Emirates Auction', 'DEALER']),
            'license_number' => fake()->randomElement(['124740', '125859', '128609', '131574', '133289', '13529', '14852', '150108', '150931', '152131', '154457', '154479', '154825', '15707', '160253', '160360', '162939', '1653032', '168919', '169162', '174046', '174643', '176108', '176328', '177534', '182682', '182849', '190839', '191657']),
            'purchase_date' => fake()->date,
            'country_id' => data_get($city, 'state.country_id'),
            'state_id' => $city?->state_id,
            'city_id' => $city?->id,
            'location_id' => Location::inRandomOrder()->value('id'),
            'title_amount' => random_int(0, 500),
            'storage_amount' => random_int(500, 1500),
            'additional_charges' => random_int(0, 50),
            'condition' => fake()->randomElement([null, 1, 2]),
            'damaged' => fake()->randomElement([null, 1, 2]),
            'pictures' => fake()->randomElement([null, 1, 2]),
            'title_received' => fake()->randomElement([null, 1, 2]),
            'towed' => fake()->randomElement([null, 1, 2]),
            'keys' => fake()->randomElement([null, 1, 2]),
            'title_received_date' => fake()->date,
            'title_number' => fake()->randomNumber(5),
            'title_state' => fake()->randomAscii(),
            'towing_request_date' => fake()->date,
            'pickup_date' => fake()->date,
            'deliver_date' => fake()->date,
            'tow_by' => fake()->randomElement([1, 2, 3]),
            'tow_fee' => fake()->randomNumber(3),
            'title_type_id' => random_int(1, 17),
            'status' => fake()->randomElement([1, 2, 3, 6, 8, 10, 12, 15, 20]),
        ];
    }

    private function generateVin()
    {
        $vinCharacters = 'ABCDEFGHJKLMNPRSTUVWXYZ1234567890'; // Exclude I, O, Q
        $vin = '';

        for ($i = 0; $i < 11; $i++) {
            $vin .= $vinCharacters[rand(0, strlen($vinCharacters) - 1)];
        }

        return $vin.random_int(100000, 999999);
    }
}
