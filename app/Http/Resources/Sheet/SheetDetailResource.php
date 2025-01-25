<?php

namespace App\Http\Resources\Sheet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SheetDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'status_name' => $this->status->getLabel(),
        ];
    }
}
