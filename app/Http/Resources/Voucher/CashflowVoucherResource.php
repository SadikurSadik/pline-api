<?php

namespace App\Http\Resources\Voucher;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CashflowVoucherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => Carbon::parse($this->date)->format('d/m/Y'),
            'voucher_number' => $this->voucher_number,
            'customer_name' => data_get($this, 'name'),
            'description' => $this->description,
            'payment_mode' => data_get($this, 'payment_method.holder_name'),
            'credit_amount' => number_format(abs($this->amount)),
            'voucher_type' => $this->account === 3 ? 'TT Cash' : 'Other Cash',
            'owner_approval_status' => 1,
            'signature_url' => ! empty($this->signature_url) ? Storage::url($this->signature_url) : null,
        ];
    }
}
