<?php

namespace App\Http\Requests\Vcc;

use Illuminate\Foundation\Http\FormRequest;

class StoreVccSubmitExitPaper extends FormRequest
{
    public function rules(): array
    {
        return [
            'receivable_claim_amount' => 'required|numeric|min:0',
            'submission_date' => 'required|date',
        ];
    }
}
