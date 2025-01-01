<?php

namespace App\Enums;

enum ContainerType: int
{
    case FEET_20 = 1;
    case FEET_40 = 2;
    case FEET_45 = 3;

    public function getLabel(): string
    {
        return match ($this) {
            ContainerType::FEET_20 => "1 X 20'HC DRY VAN",
            ContainerType::FEET_40 => "1 X 40'HC DRY VAN",
            ContainerType::FEET_45 => "1 X 45'HC DRY VAN",
        };
    }
}
