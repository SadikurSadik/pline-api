<?php

use App\Enums\VehicleStatus;

return [

    /*
    |--------------------------------------------------------------------------
    | Vehicles
    |--------------------------------------------------------------------------
    |
    | Vehicle related configuration will be here.
    |
    */

    'statuses' => [
        ['status' => 0, 'label' => 'All Vehicles', 'color' => '#', 'logo' => '/images/all_vehicles.png'],
        ['status' => VehicleStatus::NEW_PURCHASED->value, 'label' => 'New Purchased', 'color' => '#2c51d9', 'logo' => '/images/new_purchased.png'],
        ['status' => VehicleStatus::DISPATCHED->value, 'label' => 'Dispatched', 'color' => '#2c51d9', 'logo' => '/images/dispatched.png'],
        ['status' => VehicleStatus::PICKED_UP->value, 'label' => 'Picked Up', 'color' => '#2c51d9', 'logo' => '/images/loaded.png'],
        ['status' => VehicleStatus::ON_HAND->value, 'label' => 'On Hand', 'color' => '#f46a69', 'logo' => '/images/on_hand.png'],
        ['status' => VehicleStatus::READY_TO_LOAD->value, 'label' => 'Ready To Load', 'color' => '#2d99ff', 'logo' => '/images/ready_to_load.png'],
        ['status' => VehicleStatus::ON_THE_WAY->value, 'label' => 'Car On The Way', 'color' => '#ffe700', 'logo' => '/images/on_the_way.png'],
        ['status' => VehicleStatus::LOADED->value, 'label' => 'Loaded', 'color' => '#826af9', 'logo' => '/images/loaded.png'],
        ['status' => VehicleStatus::ARRIVED->value, 'label' => 'Arrived', 'color' => '#2cd9c5', 'logo' => '/images/arrived.png'],
        ['status' => VehicleStatus::RELISTED->value, 'label' => 'Relisted', 'color' => '#2c51d9', 'logo' => '/images/all_vehicles.png'],
        ['status' => VehicleStatus::HANDED_OVER->value, 'label' => 'Handed Over', 'color' => '#2cd9c5', 'logo' => '/images/handed_over.png'],
    ],

];
