<?php

namespace App\Http\Requests\State;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('states')->whereNull('deleted_at')->ignore($this->state),
            ],
            'short_code' => [
                'nullable',
                Rule::unique('states')->where('deleted_at')->ignore($this->state),
            ],
            'country_id' => 'required|integer',
            'status' => 'required|boolean',
        ];
    }
}
