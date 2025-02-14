<?php

namespace App\Http\Resources\BuyerNumber;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyerNumberDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sheet_id' => $this->sheet->id,
            'sheet_name' => $this->sheet->name,
            'parent_id' => $this->parent_id,
            'parent_name' => $this->parent?->account_name,
            'grade_id' => $this->grade_id,
            'grade_name' => $this->grade_id?->getLabel(),
            'buyer_id' => $this->buyer_id,
            'username' => $this->username,
            'password' => $this->password,
            'account_name' => $this->account_name,
            'account_type' => $this->account_type,
            'auction_name' => $this->auction_name,
            'company_name' => $this->company_name,
            'total_vehicle' => $this->vehicles_count,
            'note' => $this->note,
            'attachments' => $this->attachments,
            'status' => $this->status,
            'status_name' => $this->status->getLabel(),
            "customer_user_ids" => $this->buyer_customers?->pluck('customer.user_id')?->filter()?->values()?->toArray(),
            'customers' => CustomerBuyerNumberResource::collection($this->buyer_customers),
        ];
    }
}
