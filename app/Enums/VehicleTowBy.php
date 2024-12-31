<?php

namespace App\Enums;

enum VehicleTowBy: int
{
    case CUSTOMER = 1;
    case SHIPPING = 2;
    case SHIPPING_LINE = 3;

    public function getLabel(): string
    {
        return match ($this) {
            VehicleTowBy::CUSTOMER => 'By Customer',
            VehicleTowBy::SHIPPING => 'By Shipping',
            VehicleTowBy::SHIPPING_LINE => 'By Shipping Line',
        };
    }
}
