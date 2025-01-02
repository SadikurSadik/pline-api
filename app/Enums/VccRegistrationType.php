<?php

namespace App\Enums;

enum VccRegistrationType: int
{
    case EXIT = 1;
    case LOCAL = 3;
    case GCC = 5;
    case SCRAP = 7;

    public function getLabel(): string
    {
        return match ($this) {
            VccRegistrationType::EXIT => 'Exit',
            VccRegistrationType::LOCAL => 'Local',
            VccRegistrationType::GCC => 'GCC',
            VccRegistrationType::SCRAP => 'Scrap',
        };
    }
}
