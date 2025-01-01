<?php

namespace App\Enums;

enum CarFaxStatus: int
{
    case Pending = 1;
    case Completed = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Completed => 'Completed',
        };
    }
}
