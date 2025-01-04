<?php

namespace App\Enums;

enum VccStatus: int
{
    // vcc statuses
    case PENDING = 0;
    case ON_HAND = 1;
    case HANDED_OVER = 3;

    // exit paper statuses
    case EXIT_PAPER_NOT_RECEIVED = 4;
    case EXIT_PAPER_RECEIVED = 5;
    case GCC = 6;
    case LOCAL = 7;
    case SCRAP = 8;
    case EXIT_PAPER_SUBMITTED = 10;

    public function getLabel(): string
    {
        return match ($this) {
            VccStatus::PENDING => '',
            VccStatus::ON_HAND => 'On Hand',
            VccStatus::HANDED_OVER => 'Handed Over',
            VccStatus::EXIT_PAPER_NOT_RECEIVED => 'Exit Paper Not Received',
            VccStatus::EXIT_PAPER_RECEIVED => 'Exit Paper Received',
            VccStatus::GCC => 'GCC',
            VccStatus::LOCAL => 'Local',
            VccStatus::SCRAP => 'Scrap',
            VccStatus::EXIT_PAPER_SUBMITTED => 'Exit Paper Submitted',
        };
    }
}
