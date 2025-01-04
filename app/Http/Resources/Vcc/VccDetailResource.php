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
            'vehicle_registration_type' => $this->vehicle_registration_type->value,
            'vehicle_registration_type_name' => $this->vehicle_registration_type->getLabel(),
            'service_provider' => $this->vehicle?->service_provider,
            'container' => $this->container?->container_number,
            'arrival_date' => $this->container?->arrival_date,
            'handed_over_to' => $this->handed_over_to,
            'declaration_number' => $this->declaration_number,
            'declaration_date' => $this->declaration_date,
            'custom_duty_amount' => $this->custom_duty,
            'deposit_amount' => $this->deposit_amount,
            'exit_paper' => ! empty($this->exit_paper) ?? new ExitPaperResource($this->exit_paper),
        ];
    }
}
