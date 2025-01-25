<?php

namespace App\Http\Resources\Container;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HoustanCustomCoverLetterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'container_id' => $this->container_id,
            'vehicle_location' => $this->vehicle_location,
            'exporter_id' => $this->exporter_id,
            'exporter_type_issuer' => $this->exporter_type_issuer,
            'transportation_value' => $this->transportation_value,
            'exporter_dob' => $this->exporter_dob,
            'ultimate_consignee_dob' => $this->ultimate_consignee_dob,
            'consignee' => $this->consignee,
            'consignee_name' => data_get($this, 'consignee_item.name'),
            'notify_party' => $this->notify_party,
            'notify_party_name' => data_get($this, 'notify_party_item.name'),
            'manifest_consignee' => $this->manifest_consignee,
            'manifest_consignee_name' => data_get($this, 'manifest_consignee_item.name'),
        ];
    }
}
