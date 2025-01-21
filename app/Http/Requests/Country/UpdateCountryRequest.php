<?php

namespace App\Http\Requests\Country;

use App\Enums\BooleanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'export_vehicle' => ['required', new Enum(BooleanStatus::class)],
            'status' => ['required', 'boolean'],
        ];
    }
}
