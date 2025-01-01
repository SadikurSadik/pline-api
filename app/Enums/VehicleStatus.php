<?php

namespace App\Enums;

enum VehicleStatus: int
{
    case NEW_PURCHASED = 10;

    case NEW_REQUESTED = 11;

    case PAID = 15;

    case DISPATCHED = 20;

    case PICKED_UP = 25;

    case ON_HAND = 30;

    case READY_TO_LOAD = 40;

    case LOADED = 50;

    case ON_THE_WAY = 60;

    case ARRIVED = 70;

    case HANDED_OVER = 80;

    case RELISTED = 90;

    public function getLabel(): string
    {
        return match ($this) {
            VehicleStatus::NEW_PURCHASED => 'New Purchased',
            VehicleStatus::NEW_REQUESTED => 'New Requested',
            VehicleStatus::PAID => 'Paid',
            VehicleStatus::DISPATCHED => 'Dispatched',
            VehicleStatus::PICKED_UP => 'Picked Up',
            VehicleStatus::ON_THE_WAY => 'On the Way',
            VehicleStatus::ON_HAND => 'On Hand',
            VehicleStatus::READY_TO_LOAD => 'Ready To Load',
            VehicleStatus::LOADED => 'Loaded',
            VehicleStatus::ARRIVED => 'Arrived',
            VehicleStatus::RELISTED => 'Relisted',
            VehicleStatus::HANDED_OVER => 'Handed Over',
        };
    }
}
