<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('countries')->whereNull('deleted_at')->ignore($this->route()->country),
            ],
            'short_code' => [
                'nullable',
                Rule::unique('countries')->where('deleted_at')->ignore($this->route()->country),
            ],
            'status' => ['required', 'boolean'],
        ];
    }
}
