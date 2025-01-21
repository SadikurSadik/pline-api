<?php

namespace App\Http\Resources\ExportRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportRateResource extends JsonResource
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
            'rate' => $this->rate,
            'rate_a' => $this->rate_a,
            'rate_b' => $this->rate_b,
            'from_country_id' => $this->from_country_id,
            'from_country_name' => $this->from_country?->name,
            'to_country_id' => $this->to_country_id,
            'to_country_name' => $this->to_country?->name,
            'status' => $this->status?->value,
            'status_name' => $this->status?->getLable,
        ];
    }
}
