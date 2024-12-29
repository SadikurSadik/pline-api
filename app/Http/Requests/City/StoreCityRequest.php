<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCityRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('cities')->whereNull('deleted_at'),
            ],
            'short_code' => [
                'nullable',
                Rule::unique('cities')->where('deleted_at'),
            ],
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'status' => 'required|boolean',
        ];
    }
}
