<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserDetailResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'profile_photo' => $this->getProfilePhoto($this->profile_photo),
            'role_id' => $this->role_id->value,
            'role_name' => $this->role_id->name,
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
        ];
    }

    private function getProfilePhoto($photo): string
    {
        if (empty($photo) || ! Storage::exists($photo)) {
            return asset('images/user_default_profile.jpg');
        }

        return Storage::url($photo);
    }
}
