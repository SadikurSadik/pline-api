<?php

namespace App\Http\Requests\State;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('states')->whereNull('deleted_at'),
            ],
            'short_code' => [
                'nullable',
                Rule::unique('states')->where('deleted_at'),
            ],
            'country_id' => 'required|integer',
            'status' => 'required|boolean',
        ];
    }
}
