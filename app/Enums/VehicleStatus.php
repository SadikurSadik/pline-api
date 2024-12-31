<?php

namespace App\Enums;

enum VehicleStatus: int
{
    case ON_HAND = 1;
    case READY_TO_LOAD = 2;
    case ON_THE_WAY = 3;
    case NEW_PURCHASED = 6;
    case ARRIVED_IN_THE_PORT = 8;
    case ARRIVED = 10;
    case DISPATCHED = 12;
    case LOADED = 15;
    case RELISTED = 20;
    case HANDED_OVER = 30;

    public function getLabel(): string
    {
        return match ($this) {
            VehicleStatus::ON_HAND => 'On Hand',
            VehicleStatus::READY_TO_LOAD => 'Ready To Load',
            VehicleStatus::ON_THE_WAY => 'On the Way',
            VehicleStatus::NEW_PURCHASED => 'New Purchased',
            VehicleStatus::ARRIVED_IN_THE_PORT => 'Arrived In the Port',
            VehicleStatus::ARRIVED => 'Arrived',
            VehicleStatus::DISPATCHED => 'Dispatched',
            VehicleStatus::LOADED => 'Loaded',
            VehicleStatus::RELISTED => 'Relisted',
            VehicleStatus::HANDED_OVER => 'Handed Over',
        };
    }
}
