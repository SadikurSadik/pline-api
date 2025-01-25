<?php

namespace App\Http\Resources\Invoice;

use App\Models\Accounting\Invoice;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_id_str,
            'description' => optional($this->inventory)->description,
            'customer_name' => optional($this->customer)->name ?? '',
            'lot_number' => optional($this->inventory)->sku,
            'vin' => optional($this->inventory)->name,
            'due_date' => $this->due_date,
            'issue_date' => $this->issue_date,
            'status' => $this->status,
            'status_name' => Invoice::$statues[$this->status],
            'paid' => number_format($this->getTotal() - $this->getDue(), 2),
            'due_amount' => number_format($this->getDue(), 2),
            'due_amount_aed' => number_format($this->getDue() * $this->aed_rate, 2),
            'total_amount' => number_format($this->getTotal(), 2),
            'invoice_url' => env('ACCOUNTING_APP_URL').'/invoice/pdf/'.Crypt::encrypt($this->id).'?api_pdf=true',
        ];
    }
}
