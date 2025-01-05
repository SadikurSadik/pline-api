<?php

namespace App\Http\Requests\Complain;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplainRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => 'required|max:200',
            'message' => 'required|max:450',
        ];
    }
}
