<?php

namespace App\Enums;

enum Role: int
{
    case OWNER = 1;
    case SUPER_ADMIN = 2;
    case CUSTOMER = 3;
    case SUB_USER = 4;
    case DATA_ENTRY = 5;
    case VIEWER = 6;
    case ACCOUNTANT = 7;
    case ADMIN = 8;

    public function getLabel(): string
    {
        return match ($this) {
            Role::OWNER => 'Owner',
            Role::SUPER_ADMIN => 'Super Admin',
            Role::CUSTOMER => 'Customer',
            Role::SUB_USER => 'Sub User',
            Role::DATA_ENTRY => 'Data Entry',
            Role::VIEWER => 'Viewer',
            Role::ACCOUNTANT => 'Accountant',
            Role::ADMIN => 'Admin',
        };
    }
}
