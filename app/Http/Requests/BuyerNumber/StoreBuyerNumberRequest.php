<?php

namespace App\Http\Requests\BuyerNumber;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBuyerNumberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'buyer_id' => 'required',
            'username' => [
                'required',
                Rule::unique('buyer_numbers')->where('deleted_at'),
            ],
            'parent_id' => $this->account_type == 2 ? ['required', 'integer'] : ['nullable'],
        ];
    }
}
