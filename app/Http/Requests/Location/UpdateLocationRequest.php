<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('locations')->whereNull('deleted_at')->ignore($this->location),
            ],
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'status' => ['required', 'boolean'],
        ];
    }
}
