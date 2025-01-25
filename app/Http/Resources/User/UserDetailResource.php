<?php

namespace App\Http\Resources\User;

use App\Enums\Role;
use App\Models\Accounting\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
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
            'role' => $this->role_id->value,
            'role_id' => $this->role_id->value,
            'role_name' => $this->role_id->name,
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
            'accounting_login_url' => $this->getAccountingLoginUrlProperty(),
            'advanced_payment_report_url' => $this->advancedPaymentReportUrl(),
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
        if (! in_array($this->role_id, [Role::OWNER, Role::SUPER_ADMIN, Role::ACCOUNTANT])) {
            return null;
        }

        if (! User::find($this->id)) {
            return null;
        }

        $userId = $this->id;
        $encUserId = Crypt::encryptString($userId);

        $data = [
            'userId' => $encUserId,
        ];

        $encData = urlencode(json_encode($data));

        return env('ACCOUNTING_APP_URL').'/accounting-auth?enc_data='.$encData;
    }

    private function advancedPaymentReportUrl(): ?string
    {
        if ($this->role_id != Role::CUSTOMER) {
            return null;
        }

        return env('ACCOUNTING_APP_URL').'/customer-advance-report/'.Crypt::encrypt($this->id);
    }
}
