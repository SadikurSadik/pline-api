<?php

namespace App\Http\Resources\Vcc;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExitPaperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'received_date' => $this->received_date,
            'refund_amount' => $this->refund_amount,
            'status' => $this->status->value,
            'status_name' => $this->status->getLabel(),
            'submission_date' => $this->submission_date,
            'custom_duty_amount' => $this->custom_duty_amount,
            'receivable_claim_amount' => $this->receivable_claim_amount,
            'amount_received_in_bank' => $this->amount_received_in_bank,
            'date_amount_received_in_bank' => $this->date_amount_received_in_bank,
            'received_from' => $this->received_from,
            'received_at' => $this->received_at,
            'submitted_at' => $this->submitted_at,
        ];
    }
}
