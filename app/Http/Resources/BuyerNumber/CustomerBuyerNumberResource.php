<?php

namespace App\Http\Resources\BuyerNumber;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerBuyerNumberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer_id' => $this->customer?->user_id,
            'customer_name' => $this->customer?->name,
            'company_name' => $this->customer?->company_name,
            'phone' => $this->customer?->phone,
            'assigned_at' => $this->assigned_at,
            'unassigned_at' => $this->unassigned_at,
            'is_assigned' => empty($this->unassigned_at),
        ];
    }
}
