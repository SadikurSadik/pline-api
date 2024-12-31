<?php

namespace App\Http\Resources\ShippingRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingRateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'amount_40feet' => $this->amount_40feet,
            'amount_45feet' => $this->amount_45feet,
            'from_country_name' => data_get($this, 'from_country.name'),
            'from_state_name' => data_get($this, 'from_state.name'),
            'from_port_name' => data_get($this, 'from_port.name'),
            'to_country_name' => data_get($this, 'to_country.name'),
            'to_state_name' => data_get($this, 'to_state.name'),
            'to_port_name' => data_get($this, 'to_port.name'),
            'status_name' => $this->status->getLabel(),
        ];
    }
}
