<?php

namespace App\Http\Resources\Voucher;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdvancedVoucherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => Carbon::parse($this->date)->format('d/m/Y'),
            'voucher_number' => $this->voucher_no,
            'customer_name' => data_get($this, 'customer.name'),
            'description' => $this->note,
            'payment_mode' => data_get($this, 'payment_method.holder_name'),
            'credit_amount' => '$'.number_format(abs($this->amount)),
            'voucher_type' => 'Advance',
            'advance_type' => $this->amount < 0 ? 'Withdraw' : 'Deposit',
            'owner_approval_status' => 1,
            'signature_url' => ! empty($this->signature_url) ? Storage::url($this->signature_url) : null,
            'pdf_url' => url('api/v1/advanced-account-receipt/print-pdf/'.$this->id),
        ];
    }
}
