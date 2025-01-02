<?php

namespace App\Http\Resources\Vcc;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetVccDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vin_number' => $this->vehicle->vin_number,
            'customer_name' => $this->vehicle->customer->name,
            'custom_duty' => $this->custom_duty
        ];
    }
}
