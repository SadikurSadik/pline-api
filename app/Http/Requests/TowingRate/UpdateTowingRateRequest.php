<?php

namespace App\Http\Requests\TowingRate;

use Illuminate\Foundation\Http\FormRequest;

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
            'status' => 'nullable|boolean',
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
