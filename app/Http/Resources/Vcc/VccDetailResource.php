<?php

namespace App\Http\Resources\Vcc;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VccDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->vehicle->customer->name,
            'title' => $this->vehicle->title,
            'vin_number' => $this->vehicle->vin_number,
            'service_provider' => $this->vehicle->service_provider,
            'container' => $this->container->container_number,
            'declaration_number' => $this->declaration_number,
            'declaration_date' => $this->declaration_date,
            'custom_duty_amount' => $this->custom_duty,
        ];
    }
}
