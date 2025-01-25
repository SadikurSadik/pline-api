<?php

namespace App\Enums;

enum VehiclePhotoType: int
{
    case YARD_PHOTO = 1;
    case AUCTION_PHOTO = 2;
    case PICKUP_PHOTO = 3;
    case ARRIVED_PHOTO = 4;
    case EXPORT_PHOTO = 5;

    public function getKeyName(): string
    {
        return strtolower($this->name).'s';
    }
}
