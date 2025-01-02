<?php

namespace App\Http\Resources\Container;

use App\Http\Resources\Vehicle\VehicleDetailResource;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ContainerDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'thumbnail' => $this->getThumbnailPhoto(data_get($this, 'export_images.0.thumbnail')),
            'customer_name' => data_get($this, 'customer.name'),
            'customer_id' => data_get($this, 'customer.customer_id'),
            'customer_user_id' => $this->customer_user_id,
            'booking_number' => $this->booking_number,
            'container_number' => $this->container_number,
            'loading_date' => Carbon::parse($this->loading_date)->format('Y-m-d'),
            'export_date' => $this->export_date,
            'eta_date' => $this->eta_date,
            'cut_off_date' => $this->cut_off_date,
            'arrival_date' => $this->arrival_date,
            'streamship_line' => $this->streamship_line,
            'container_type' => $this->container_type,
            'container_type_name' => $this->container_type?->getLabel(),
            'port_of_loading_country_id' => $this->port_of_loading?->state?->country?->id,
            'port_of_loading_country_name' => $this->port_of_loading?->state?->country?->name,
            'port_of_loading_state_id' => $this->port_of_loading?->state_id,
            'port_of_loading_state_name' => $this->port_of_loading?->state?->name,
            'port_of_loading_id' => $this->port_of_loading?->id,
            'port_of_loading_name' => $this->port_of_loading?->name,
            'port_of_discharge_country_id' => $this->port_of_discharge?->state?->country?->id,
            'port_of_discharge_country_name' => $this->port_of_discharge?->state?->country?->name,
            'port_of_discharge_state_id' => $this->port_of_discharge?->state_id,
            'port_of_discharge_state_name' => $this->port_of_discharge?->state?->name,
            'port_of_discharge_id' => $this->port_of_discharge?->id,
            'port_of_discharge_name' => $this->port_of_discharge?->name,
            'status' => $this->status,
            'status_name' => $this->status?->getLabel(),
            'seal_number' => $this->seal_number,
            'vessel' => $this->vessel,
            'voyage' => $this->voyage,
            'xtn_number' => $this->xtn_number,
            'itn' => $this->itn,
            'broker_name' => $this->broker_name,
            'oti_number' => $this->oti_number,
            'terminal' => $this->terminal,
            'destination' => $this->destination,
            'ar_number' => $this->ar_number,
            'contact_detail' => $this->contact_detail,
            'special_instruction' => $this->special_instruction,
            'bol_note' => $this->bol_note,
            'vehicle_ids' => $this->vehicles->pluck('id'),
            'vehicles' => VehicleDetailResource::collection($this->vehicles),
            'dock_receipt' => !empty($this->dock_receipt) ? new DockReceiptResource($this->dock_receipt) : new \stdClass,
            'houstan_custom_cover_letter' => !empty($this->houstan_custom_cover_letter) ? new HoustanCustomCoverLetterResource($this->houstan_custom_cover_letter) : new \stdClass,
            'file_urls' => [
                'container_photos' => $this->getPhotosProperty($this->container_photos),
                'empty_container_photos' => $this->getPhotosProperty($this->empty_container_photos),
                'loading_photos' => $this->getPhotosProperty($this->loading_photos),
                'loaded_photos' => $this->getPhotosProperty($this->loaded_photos),
                'documents' => $this->getDocumentProperty($this->documents),
            ],
        ];
    }

    private function getThumbnailPhoto($photo): Application|string|UrlGenerator
    {
        if (empty($photo)) {
            return url('images/car-default-photo.png');
        }

        return filter_var($photo, FILTER_VALIDATE_URL) === false ? Storage::url($photo) : $photo;
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
