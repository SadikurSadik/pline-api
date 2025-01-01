<?php

namespace App\Enums;

enum ContainerStatus: int
{
    case ON_THE_WAY = 3;
    case ARRIVED_IN_THE_PORT = 8;
    case ARRIVED = 10;
    case LOADED = 15;

    public function getLabel(): string
    {
        return match ($this) {
            ContainerStatus::ON_THE_WAY => 'On the Way',
            ContainerStatus::ARRIVED_IN_THE_PORT => 'Arrived In the Port',
            ContainerStatus::ARRIVED => 'Arrived',
            ContainerStatus::LOADED => 'Loaded',
        };
    }
}
