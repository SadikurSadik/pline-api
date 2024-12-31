<?php

namespace App\Enums;

enum VehicleDocumentType: int
{
    case DOCUMENT = 1;
    case INVOICE = 2;

    public function getKeyName(): string
    {
        return strtolower($this->name).'s';
    }
}
