<?php

namespace App\Http\Resources\DamageClaim;

use App\Http\Resources\Vehicle\VehicleDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DamageClaimDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vehicle' => new VehicleDetailResource($this->vehicle),
            'customer_user_id' => $this->customer_user_id,
            'customer_name' => $this->customer?->name,
            'claim_amount' => $this->claim_amount,
            'description' => $this->description,
            'note' => $this->when(! is_customer(), $this->note),
            'approved_amount' => $this->approved_amount,
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
            'approve_reject_by' => $this->user?->name,
            'approve_reject_at' => dateTimeFormat($this->approve_reject_at),
            'photos' => collect($this->photos)->map(function ($photo) {
                return filter_var($photo, FILTER_VALIDATE_URL) === false ? Storage::url($photo) : $photo;
            }),
        ];
    }
}
