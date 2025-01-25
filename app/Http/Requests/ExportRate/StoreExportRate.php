<?php

namespace App\Http\Requests\ExportRate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExportRate extends FormRequest
{
    public function rules(): array
    {
        return [
            'rate' => 'required|numeric',
            'rate_a' => 'required|numeric',
            'rate_b' => 'required|numeric',
            'from_country_id' => 'required|integer',
            'to_country_id' => [
                'required',
                Rule::unique('export_rates')->whereNull('deleted_at'),
            ],
            'status' => 'required|boolean',
        ];
    }
}
