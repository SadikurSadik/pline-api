<?php

namespace App\Http\Requests\Vcc;

use App\Enums\VccRegistrationType;
use Illuminate\Foundation\Http\FormRequest;

class VccHandOverRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_registration_type' => ['required', 'integer'],
            'handed_over_date' => ['required', 'date'],
            'handed_over_time' => ['required', 'date_format:H:i'],
            'handed_over_to' => ['required', 'string'],
            'deposit_amount' => $this->vehicle_registration_type == VccRegistrationType::EXIT->value ? ['required', 'min:0', 'numeric'] : ['nullable'],
        ];
    }
}
