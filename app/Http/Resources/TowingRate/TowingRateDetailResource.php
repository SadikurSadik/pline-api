<?php

namespace App\Http\Resources\TowingRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TowingRateDetailResource extends JsonResource
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
            'rate' => $this->rate,
            'rate_a' => $this->rate_a,
            'rate_b' => $this->rate_b,
            'country_id' => $this->country_id,
            'country_name' => data_get($this, 'country.name'),
            'state_id' => $this->state_id,
            'state_name' => data_get($this, 'state.name'),
            'city_id' => $this->city_id,
            'city_name' => data_get($this, 'city.name'),
            'location_id' => $this->location_id,
            'location_name' => data_get($this, 'location.name'),
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
