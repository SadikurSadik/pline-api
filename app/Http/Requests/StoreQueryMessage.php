<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQueryMessage extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:15',
            'message' => 'required|max:350',
        ];
    }
}
