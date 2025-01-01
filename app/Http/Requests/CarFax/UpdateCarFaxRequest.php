<?php

namespace App\Http\Requests\CarFax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarFaxRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vin' => [
                'required',
                'string',
                'max:50',
                Rule::unique('car_faxes', 'vin')->whereNull('deleted_at')->ignore($this->route('car_fax')),
            ],
            'year' => 'required|integer|digits:4',
            'make' => 'required|string|max:150',
            'model' => 'required|string|max:150',
            'color' => 'nullable|string|max:100',
            'document_url' => 'required|url|max:150',
            'note' => 'nullable|string|max:500',
        ];
    }
}
