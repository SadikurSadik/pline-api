<?php

namespace App\Http\Resources\Voucher;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class InvoiceVoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => Carbon::parse($this->date)->format('d/m/Y'),
            'customer_name' => data_get($this, 'invoice.customer.name'),
            'vin' => data_get($this, 'invoice.inventory.name'),
            'title' => data_get($this, 'invoice.inventory.description'),
            'voucher_number' => $this->reference,
            'description' => $this->description,
            'payment_mode' => data_get($this, 'bankAccount.holder_name', '-'),
            'credit_amount' => '$'.number_format($this->amount),
            'voucher_type' => $this->invoice->ak_type == 'service' ? 'Shipping' : 'Vehicle',
            'invoice_number' => $this->invoice->invoice_id_str,
            'signature_url' => ! empty($this->signature_url) ? Storage::url($this->signature_url) : null,
            'pdf_url' => url('api/v1/invoice/payment-receipt?invoice_payment_id='.$this->id),
        ];
    }
}
