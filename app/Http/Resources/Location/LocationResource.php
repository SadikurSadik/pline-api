<?php

namespace App\Http\Resources\Location;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'name' => $this->name,
            'country_id' => $this->country_id,
            'country_name' => data_get($this, 'country.name'),
            'state_id' => $this->state_id,
            'state_name' => data_get($this, 'state.name'),
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
