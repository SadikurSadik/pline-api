<?php

namespace App\Http\Requests\Port;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePortRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('ports')->whereNull('deleted_at')->ignore($this->port),
            ],
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'status' => 'nullable|boolean',
        ];
    }
}
