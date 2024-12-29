<?php

namespace App\Http\Resources\Port;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortResource extends JsonResource
{
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
