<?php

namespace App\Http\Resources\TowingRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TowingRateResource extends JsonResource
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
            'country_name' => data_get($this, 'country.name'),
            'state_name' => data_get($this, 'state.name'),
            'city_name' => data_get($this, 'city.name'),
            'location_name' => data_get($this, 'location.name'),
            'status_name' => $this->status->getLabel(),
        ];
    }
}
