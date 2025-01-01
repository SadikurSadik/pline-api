<?php

namespace App\Http\Resources\Container;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ContainerPhotosResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'container_photos' => $this->getPhotosProperty($this->container_photos),
            'empty_container_photos' => $this->getPhotosProperty($this->empty_container_photos),
            'loading_photos' => $this->getPhotosProperty($this->loading_photos),
            'loaded_photos' => $this->getPhotosProperty($this->loaded_photos),
        ];
    }

    private function getPhotosProperty($photos)
    {
        return collect($photos)->reject(function ($item) {
            return ! Storage::exists($item['name']);
        })->map(function ($item) {
            return [
                'name' => filter_var($item['name'],
                    FILTER_VALIDATE_URL) === false ? Storage::url($item['name']) : $item['name'],
                'thumbnail' => filter_var($item['thumbnail'],
                    FILTER_VALIDATE_URL) === false ? Storage::url($item['thumbnail']) : $item['thumbnail'],
            ];
        })->values();
    }
}
