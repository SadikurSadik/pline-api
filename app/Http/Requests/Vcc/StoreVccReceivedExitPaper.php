<?php

namespace App\Http\Requests\Vcc;

use Illuminate\Foundation\Http\FormRequest;

class StoreVccReceivedExitPaper extends FormRequest
{
    public function rules(): array
    {
        return [
            'received_date' => 'required|date',
            'received_time' => 'required|date_format:H:i',
            'refund_amount' => 'required|numeric',
        ];
    }
}
