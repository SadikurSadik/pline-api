<?php

namespace App\Enums;

abstract class VccStatus
{
    // vcc statuses
    const ON_HAND = 1;

    const HANDED_OVER = 3;

    // exit paper statuses
    const EXIT_PAPER_NOT_RECEIVED = 4;

    const EXIT_PAPER_RECEIVED = 5;

    const GCC = 6;

    const LOCAL = 7;

    const SCRAP = 8;

    const EXIT_PAPER_SUBMITTED = 10;
}
