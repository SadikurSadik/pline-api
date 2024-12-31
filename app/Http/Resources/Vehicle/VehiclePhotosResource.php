<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VehiclePhotosResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'yard_photos' => $this->getPhotosProperty($this->yard_photos),
            'auction_photos' => $this->getPhotosProperty($this->auction_photos),
            'pickup_photos' => $this->getPhotosProperty($this->pickup_photos),
            'arrived_photos' => $this->getPhotosProperty($this->arrived_photos),
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
