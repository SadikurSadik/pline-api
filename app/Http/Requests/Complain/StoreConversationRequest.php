<?php

namespace App\Http\Requests\Complain;

use Illuminate\Foundation\Http\FormRequest;

class StoreConversationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => 'required|max:200',
            'model_id' => 'required|integer',
        ];
    }
}
