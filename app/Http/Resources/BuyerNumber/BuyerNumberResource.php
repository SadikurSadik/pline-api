<?php

namespace App\Http\Resources\BuyerNumber;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyerNumberResource extends JsonResource
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
            'buyer_id' => $this->buyer_id,
            'username' => $this->username,
            'password' => $this->password,
            'account_name' => $this->account_name,
            'grade_name' => $this->grade_id?->getLabel(),
            'auction_name' => $this->auction_name,
            'company_name' => $this->company_name,
            'assigned_customer' => $this->buyer_customers?->pluck('customer.name')?->implode(', '),
            'note' => $this->note,
            'total_vehicle' => $this->vehicles_count,
            'status' => $this->status,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
