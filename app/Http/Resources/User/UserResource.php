<?php

namespace App\Http\Resources\User;

use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'role_name' => $this->role_id->name,
            'status_name' => $this->status->getLabel(),
            'profile_photo' => $this->getProfilePhoto($this->profile_photo),
            'accounting_login_url' => $this->getAccountingLoginUrlProperty(),
        ];
    }

    private function getProfilePhoto($photo): string
    {
        if (empty($photo) || ! Storage::exists($photo)) {
            return asset('images/user_default_profile.jpg');
        }

        return Storage::url($photo);
    }

    private function getAccountingLoginUrlProperty(): ?string
    {
        if( !in_array( auth()->user()->role_id, [Role::OWNER, Role::SUPER_ADMIN, Role::ACCOUNTANT] ) ) {
            return null;
        }

        $userId = auth()->user()->id;
        $encUserId = Crypt::encryptString($userId);

        $data = [
            'userId' => $encUserId
        ];

        $encData = urlencode( json_encode($data) );

        return env('ACCOUNTING_APP_URL') . '/accounting-auth?enc_data='. $encData;
    }
}
