<?php

namespace App\Http\Requests\Country;

use App\Enums\VisibilityStatus;
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
            'status' => ['nullable', Rule::in(VisibilityStatus::ACTIVE->value, VisibilityStatus::INACTIVE->value)],
        ];
    }
}
