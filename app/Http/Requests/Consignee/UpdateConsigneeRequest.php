<?php

namespace App\Http\Requests\Consignee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsigneeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_user_id' => 'required|integer',
            'name' => 'required|max:200',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:500',
            'country_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
        ];
    }
}
