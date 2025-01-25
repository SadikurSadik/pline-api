<?php

namespace App\Http\Requests\User;

use App\Enums\BooleanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:200',
            'username' => [
                'required',
                'max:200',
                Rule::unique('users')->whereNull('deleted_at')->ignore($this->user),
            ],
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users')->whereNull('deleted_at')->ignore($this->user),
            ],
            //            'password' => 'required|min:6|max:12',
            'profile_photo' => ['nullable', 'max:200'],
            'role_id' => 'required|integer',
            'status' => ['nullable', new Enum(BooleanStatus::class)],
        ];
    }
}
