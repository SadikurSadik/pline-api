<?php

namespace App\Http\Resources\Pricing;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PricingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => sprintf('%s to %s', Carbon::parse($this->created_at)->format('d F Y'),
                $this->expire_at ? Carbon::parse($this->expire_at)->format('d F Y') : 'Present'),
            'pdf_url' => $this->getPricingPdfUrl($this->pdf_url),
        ];
    }

    private function getPricingPdfUrl($url): ?string
    {
        if (empty($url)) {
            return null;
        }

        return filter_var($url, FILTER_VALIDATE_URL) === false ? Storage::url($url) : $url;
    }
}
