<?php

namespace App\Http\Requests\CarFax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerCarFaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role_id === 4;
    }

    public function rules(): array
    {
        return [
            'vin' => [
                'required',
                'string',
                'max:50',
                Rule::unique('car_faxes', 'vin')->whereNull('deleted_at'),
            ],
        ];
    }
}
