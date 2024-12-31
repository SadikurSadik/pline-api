<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'username' => $this->user?->username,
            'email' => $this->user?->email,
            'phone' => $this->phone,
            'vehicles_count' => 0,
            'on_hand_count' => 0,
            'on_the_way_count' => 0,
            'arrived_count' => 0,
            'status' => $this->user?->status,
            'status_name' => ! empty($this->user) ? $this->user->status->getLabel() : '',
        ];
    }
}
