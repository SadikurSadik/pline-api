<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'thumbnail' => $this->getThumbnailPhoto(data_get($this, 'yard_photos.0.name')),
            'title' => $this->title,
            'customer_name' => data_get($this, 'customer.name'),
            'lot_number' => $this->lot_number,
            'vin_number' => $this->vin_number,
            'purchase_date' => $this->purchase_date,
            'location_name' => data_get($this, 'location.name'),
            'auction_name' => $this->auction_name,
            'service_provider' => $this->service_provider,
            'value' => $this->value,
            'note_status' => $this->note_status,
            'note' => $this->note,
            'container_id' => $this->container_id,
            'container_number' => $this->container?->container_number,
            'keys_name' => $this->keys?->getLabel(),
            'status_name' => $this->status->getLabel(),
        ];
    }

    private function getThumbnailPhoto($photo): Application|string|UrlGenerator
    {
        if (empty($photo)) {
            return url('images/car-default-photo.png');
        }

        return filter_var($photo, FILTER_VALIDATE_URL) === false ? Storage::url($photo) : $photo;
    }
}
