<?php

namespace App\Http\Requests\Vcc;

use Illuminate\Foundation\Http\FormRequest;

class StoreVccAttachmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vcc_attachment' => 'required',
            'bill_of_entry_attachment' => 'required',
            'other_attachment' => 'required',
        ];
    }
}
