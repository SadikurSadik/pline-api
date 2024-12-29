<?php

namespace App\Http\Resources\State;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_code' => $this->short_code,
            'country_id' => $this->country_id,
            'country_name' => $this->country?->name,
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
