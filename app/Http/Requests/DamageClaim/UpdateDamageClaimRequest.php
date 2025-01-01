<?php

namespace App\Http\Requests\DamageClaim;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDamageClaimRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id' => [
                'required',
                'exists:vehicles,id',
                Rule::unique('damage_claims')->whereNull('deleted_at')->ignore($this->route('damage_claim')),
            ],
            'claim_amount' => 'required|numeric',
            'approved_amount' => 'required|numeric',
            'description' => 'required|string',
            'note' => 'nullable|string',
            'photos' => 'required|array|min:1',
            'photos.*' => 'required|url',
            'attachment' => 'nullable|url',
            'status' => 'required|in:1,2,3',
        ];
    }
}
