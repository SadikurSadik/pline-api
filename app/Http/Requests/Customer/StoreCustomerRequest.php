<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:200',
            'company_name' => 'nullable|max:200',
            'phone' => 'required|max:20',
            'phone_two' => 'nullable|max:20',
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
            'trn' => 'nullable|max:20',
            'profile_photo' => 'nullable|url',
            'address' => 'nullable|max:500',
            'country_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'buyer_ids' => 'nullable|array',
            'documents' => 'nullable|array',
        ];
    }
}
