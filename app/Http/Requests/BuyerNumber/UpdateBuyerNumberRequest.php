<?php

namespace App\Http\Requests\BuyerNumber;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBuyerNumberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'buyer_id' => ['required'],
            'username' => ['required',
                Rule::unique('buyer_numbers')->where('deleted_at')->ignore($this->buyer_number),
            ],
        ];
    }
}
