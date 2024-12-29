<?php

namespace App\Http\Resources\TitleType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TitleTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
