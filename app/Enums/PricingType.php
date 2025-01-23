<?php

namespace App\Enums;

enum PricingType: int
{
    case IMPORT = 1;
    case EXPORT = 2;

    public function getLabel(): string
    {
        return match ($this) {
            PricingType::IMPORT => 'Import',
            PricingType::EXPORT => 'Export',
        };
    }
}
