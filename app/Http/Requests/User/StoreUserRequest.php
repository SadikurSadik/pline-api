<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:200',
            'username' => [
                'required',
                'max:200',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:6|max:12',
            'profile_photo' => ['nullable', 'max:200'],
            'role_id' => 'required|integer',
            'status' => 'nullable|boolean',
        ];
    }
}
