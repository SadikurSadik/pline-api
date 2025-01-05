<?php

namespace App\Http\Requests\Complain;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class StoreComplainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role_id == Role::CUSTOMER;
    }

    public function rules(): array
    {
        return [
            'subject' => 'required|max:200',
            'message' => 'required|max:450',
        ];
    }
}
