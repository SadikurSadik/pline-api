<?php

namespace App\Http\Resources\City;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_code' => $this->short_code,
            'state_id' => data_get($this, 'state.id'),
            'state_name' => data_get($this, 'state.name'),
            'country_id' => data_get($this, 'state.country.id'),
            'country_name' => data_get($this, 'state.country.name'),
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
