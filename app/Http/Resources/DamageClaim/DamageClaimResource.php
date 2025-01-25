<?php

namespace App\Http\Resources\DamageClaim;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DamageClaimResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vehicle_id' => $this->vehicle?->id,
            'customer_user_id' => $this->vehicle?->customer_user_id,
            'vin_number' => $this->vehicle?->vin_number,
            'customer_name' => $this->customer?->name,
            'claim_amount' => $this->claim_amount,
            'approved_amount' => $this->approved_amount,
            'description' => $this->description,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
