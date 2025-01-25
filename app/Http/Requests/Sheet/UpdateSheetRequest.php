<?php

namespace App\Http\Requests\Sheet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSheetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'status' => ['required', 'integer'],
        ];
    }
}
