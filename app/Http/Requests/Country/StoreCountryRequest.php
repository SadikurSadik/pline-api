<?php

namespace App\Http\Requests\Country;

use App\Enums\VisibilityStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreCountryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('countries')->whereNull('deleted_at'),
            ],
            'short_code' => [
                'nullable',
                Rule::unique('countries')->where('deleted_at'),
            ],
            'status' => ['nullable', new Enum(VisibilityStatus::class)],
        ];
    }
}
