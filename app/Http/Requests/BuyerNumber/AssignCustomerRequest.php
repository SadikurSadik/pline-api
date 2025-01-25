<?php

namespace App\Http\Requests\BuyerNumber;

use Illuminate\Foundation\Http\FormRequest;

class AssignCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_user_ids' => ['required', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_user_ids.required' => 'The assign customer field is required.',
        ];
    }
}
