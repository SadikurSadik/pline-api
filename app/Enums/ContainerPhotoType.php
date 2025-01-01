<?php

namespace App\Enums;

enum ContainerPhotoType: int
{
    case CONTAINER_PHOTO = 1;
    case EMPTY_CONTAINER_PHOTO = 2;
    case LOADING_PHOTO = 3;
    case LOADED_PHOTO = 4;

    public function getKeyName(): string
    {
        return strtolower($this->name).'s';
    }
}
