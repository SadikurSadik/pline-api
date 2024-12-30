<?php

namespace App\Http\Resources\Consignee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsigneeDetailResource extends JsonResource
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
            'customer_user_id' => $this->customer_user_id,
            'customer_name' => data_get($this, 'customer.name'),
            'name' => $this->name,
            'phone' => $this->phone,
            'country_id' => $this->country_id,
            'country_name' => data_get($this, 'country.name'),
            'state_id' => $this->state_id,
            'state_name' => data_get($this, 'state.name'),
            'city_id' => $this->city_id,
            'city_name' => data_get($this, 'city.name'),
            'address' => $this->address,
        ];
    }
}
