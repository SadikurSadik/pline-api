<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class CustomerDetailResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'username' => $this->user?->username,
            'profile_photo' => $this->getProfilePhoto($this->user?->profile_photo),
            'email' => $this->user?->email,
            'phone' => $this->phone,
            'trn' => $this->trn,
            'address' => $this->address,
            'buyer_ids' => $this->buyer_ids,
            'country_id' => $this->country_id,
            'country_name' => $this->country?->name,
            'state_id' => $this->state_id,
            'state_name' => $this->state?->name,
            'city_id' => $this->city_id,
            'city_name' => $this->city?->name,
            'category' => $this->category,
            'documents' => $this->customerDocuments($this->documents ?? []),
            'status' => $this->user?->status,
            'status_name' => ! empty($this->user) ? $this->user->status->getLabel() : '',
        ];
    }

    private function customerDocuments($documents)
    {
        return Arr::map($documents, function ($document) {
            return filter_var($document, FILTER_VALIDATE_URL) === false ? Storage::url($document) : $document;
        });
    }

    private function getProfilePhoto(mixed $profilePhoto)
    {
        if (empty($profilePhoto)) {
            // return default profile photo
            return '';
        }

        return filter_var($profilePhoto, FILTER_VALIDATE_URL) ? $profilePhoto : Storage::url($profilePhoto);
    }
}
