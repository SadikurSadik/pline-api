<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VehicleDetailResource extends JsonResource
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
            'title' => $this->title,
            'customer_user_id' => $this->customer_user_id,
            'customer_id' => data_get($this, 'customer.customer_id'),
            'customer_name' => data_get($this, 'customer.name'),
            'lot_number' => $this->lot_number,
            'vin_number' => $this->vin_number,
            'purchase_date' => $this->purchase_date,
            'location_name' => data_get($this, 'location.name'),
            'auction_name' => $this->auction_name,
            'service_provider' => $this->service_provider,
            'value' => $this->value,
            'weight' => $this->weight,
            'license_number' => $this->license_number,
            'additional_charges' => $this->additional_charges,
            'storage_amount' => $this->storage_amount,
            'year' => $this->year,
            'make' => $this->make,
            'model' => $this->model,
            'color' => $this->color,
            'country_name' => data_get($this, 'country.name'),
            'state_name' => data_get($this, 'state.name'),
            'city_name' => data_get($this, 'city.name'),
            'country_id' => data_get($this, 'country.id'),
            'state_id' => data_get($this, 'state.id'),
            'city_id' => data_get($this, 'city.id'),
            'location_id' => data_get($this, 'location.id'),
            'condition' => $this->condition?->value,
            'condition_name' => $this->condition?->getLabel(),
            'damaged' => $this->damaged?->value,
            'damaged_name' => $this->damaged?->getLabel(),
            'pictures' => $this->pictures?->value,
            'pictures_name' => $this->pictures?->getLabel(),
            'towed' => $this->towed?->value,
            'towed_name' => $this->towed?->getLabel(),
            'keys' => $this->keys?->value,
            'keys_name' => $this->keys?->getLabel(),
            'title_received' => $this->title_received?->value,
            'title_received_name' => $this->title_received?->getLabel(),
            'title_received_date' => $this->title_received_date,
            'title_number' => $this->title_number,
            'title_amount' => $this->title_amount,
            'title_state' => $this->title_state,
            'towing_request_date' => $this->towing_request_date,
            'pickup_date' => $this->pickup_date,
            'deliver_date' => $this->deliver_date,
            'tow_by' => $this->tow_by?->value,
            'tow_by_name' => $this->tow_by?->getLabel(),
            'tow_fee' => $this->tow_fee,
            'title_type_id' => $this->title_type_id,
            'title_type_name' => data_get($this, 'title_type.name'),
            'status' => $this->status,
            'status_name' => $this->status->getLabel(),
            'vehicle_conditions' => $this->vehicle_conditions->pluck('value', 'condition_id'),
            'vehicle_features' => $this->vehicle_features->pluck('value', 'condition_id'),
            'file_urls' => [
                'yard_photos' => $this->getPhotosProperty($this->yard_photos),
                'auction_photos' => $this->getPhotosProperty($this->auction_photos),
                'pickup_photos' => $this->getPhotosProperty($this->pickup_photos),
                'arrived_photos' => $this->getPhotosProperty($this->arrived_photos),
                'documents' => $this->getDocumentProperty($this->documents),
                'invoices' => $this->getDocumentProperty($this->invoices),
            ],
            'show_damage_claim_button' => true,
        ];
    }

    private function getPhotosProperty($photos)
    {
        return collect($photos)->reject(function ($item) {
            return ! Storage::exists($item['name']);
        })->map(function ($item) {
            return [
                'name' => filter_var($item['name'], FILTER_VALIDATE_URL) === false ? Storage::url($item['name']) : $item['name'],
                'thumbnail' => filter_var($item['thumbnail'], FILTER_VALIDATE_URL) === false ? Storage::url($item['thumbnail']) : $item['thumbnail'],
            ];
        })->values();
    }

    private function getDocumentProperty($photos)
    {
        return collect($photos)->reject(function ($item) {
            return ! Storage::exists($item['name']);
        })->map(function ($item) {
            return filter_var($item['name'], FILTER_VALIDATE_URL) === false ? Storage::url($item['name']) : $item['name'];
        })->values();
    }
}
