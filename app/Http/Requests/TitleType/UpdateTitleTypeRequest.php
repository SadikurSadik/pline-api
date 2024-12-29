<?php

namespace App\Http\Requests\TitleType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTitleTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('title_types')->whereNull('deleted_at')->ignore($this->title_type),
            ],
            'status' => 'nullable|boolean',
        ];
    }
}
