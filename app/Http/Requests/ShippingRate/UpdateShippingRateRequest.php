<?php

namespace App\Http\Requests\ShippingRate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingRateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric',
            'amount_40feet' => 'required|numeric',
            'amount_45feet' => 'required|numeric',
            'from_country_id' => 'required|integer',
            'from_state_id' => 'required|integer',
            'from_port_id' => 'required|integer',
            'to_country_id' => 'required|integer',
            'to_state_id' => 'required|integer',
            'to_port_id' => 'required|integer',
            'status' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'from_country_id.required' => 'The from country field is required.',
            'from_state_id.required' => 'The from state field is required.',
            'from_port_id.required' => 'The from port field is required.',
            'to_country_id.required' => 'The to country field is required.',
            'to_state_id.required' => 'The to state field is required.',
            'to_port_id.required' => 'The to port field is required.',
        ];
    }
}
