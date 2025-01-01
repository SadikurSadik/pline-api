<?php

namespace App\Http\Resources\CarFax;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CarFaxResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lot_number' => $this->lot_number,
            'vin' => $this->vin,
            'year' => $this->year,
            'make' => $this->make,
            'model' => $this->model,
            'color' => $this->color,
            'document_url' => $this->getDocumentUrl($this->document_url),
            'requested_by_name' => $this->customer?->name,
            'note' => $this->note,
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
        ];
    }

    private function getDocumentUrl($documentUrl): ?string
    {
        if (empty($documentUrl)) {
            return null;
        }

        return filter_var($documentUrl, FILTER_VALIDATE_URL) === false ?
            Storage::url($documentUrl) : $documentUrl;
    }
}
