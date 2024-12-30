<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('roles')->ignore($this->role),
            ],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => 'required|integer',
        ];
    }
}
