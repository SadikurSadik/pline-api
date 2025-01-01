<?php

namespace App\Http\Requests\DamageClaim;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDamageClaimRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id' => [
                'required',
                'exists:vehicles,id',
                Rule::unique('damage_claims')->whereNull('deleted_at'),
            ],
            'customer_user_id' => 'required|int',
            'claim_amount' => 'required|numeric',
            'description' => 'required|string',
            'photos' => 'required|array|min:1',
            'photos.*' => 'required|url',
        ];
    }
}
