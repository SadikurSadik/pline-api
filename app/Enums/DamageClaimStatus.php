<?php

namespace App\Enums;

enum DamageClaimStatus: int
{
    case Pending = 1;
    case Approved = 2;
    case Rejected = 3;

    public function getLabel(): string
    {
        return match ($this) {
            DamageClaimStatus::Pending => 'Pending',
            DamageClaimStatus::Approved => 'Approved',
            DamageClaimStatus::Rejected => 'Rejected',
            default => 'Unknown',
        };
    }
}
