<?php

namespace App\Http\Requests\Vcc;

use Illuminate\Foundation\Http\FormRequest;

class StoreVccDetailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'declaration_number' => [
                'required',
                'string',
                'max:100',
            ],
            'declaration_date' => 'required|date',
            'custom_duty.*' => 'required|numeric',
            'received_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'custom_duty.*.required' => 'The custom duty field is required.',
            'custom_duty.*.numeric' => 'The custom duty must be number.',
        ];
    }
}
