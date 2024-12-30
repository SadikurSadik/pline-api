<?php

namespace App\Http\Resources\Consignee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsigneeResource extends JsonResource
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
            'customer_name' => data_get($this, 'customer.name'),
            'name' => $this->name,
            'phone' => $this->phone,
        ];
    }
}
