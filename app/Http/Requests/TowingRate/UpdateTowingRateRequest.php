<?php

namespace App\Http\Requests\TowingRate;

use App\Enums\VisibilityStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTowingRateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rate' => 'required|numeric',
            'rate_a' => 'required|numeric',
            'rate_b' => 'required|numeric',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'location_id' => 'required|integer',
            'status' => ['nullable', new Enum(VisibilityStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_id.required' => 'The city field is required.',
            'location_id.required' => 'The location field is required.',
        ];
    }
}
