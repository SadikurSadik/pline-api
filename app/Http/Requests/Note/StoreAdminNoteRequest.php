<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminNoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|string',
        ];
    }
}
