<?php

namespace App\Http\Requests\ClearanceRate;

use Illuminate\Foundation\Http\FormRequest;

class StoreClearanceRateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'clearance_rate' => 'required|numeric|min:0',
            'profit' => 'required|numeric|min:0',
        ];
    }
}
