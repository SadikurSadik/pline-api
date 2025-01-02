<?php

namespace App\Http\Resources\Vcc;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VccResource extends JsonResource
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
            'customer_name' => $this->vehicle->customer->name,
            'title' => $this->vehicle->title,
            'vin_number' => $this->vehicle->vin_number,
            'invoice' => null,
            'note' => null,
            'service_provider' => $this->vehicle->service_provider,
            'container' => $this->container->container_number,
            'declaration_number' => $this->declaration_number,
            'declaration_date' => $this->declaration_date,
            'status_name' => $this->status,
            'vehicle_registration_type' => $this->vehicle_registration_type,
            'vcc_received_date' => $this->received_date,
            'hand_over_date' => \Carbon\Carbon::parse($this->handed_over_at)->format('d-m-Y'),
            'hand_over_time' => \Carbon\Carbon::parse($this->handed_over_at)->format('H:i:s'),
            'hand_over_to' => $this->handed_over_to,
            'deposit_amount' => $this->deposit_amount,
            'refund_amount' => $this->exit_paper?->refund_amount,
            'exit_paper_received_date' => \Carbon\Carbon::parse($this->exit_paper?->received_at)->format('d-m-Y'),
            'exit_paper_received_time' => \Carbon\Carbon::parse($this->exit_paper?->received_at)->format('H:i:s'),
            'exit_paper_status' => $this->exit_paper?->status,
            'exit_paper_submission_date' => \Carbon\Carbon::parse($this->exit_paper?->submission_date)->format('d-m-Y'),
            'submission_note' => null,
            'custom_duty_amount' => $this->custom_duty,
            'receivable_claim_amount' => $this->exit_paper?->receivable_claim_amount,
            'amount_received_in_bank' => $this->exit_paper?->amount_received_in_bank,
            'date_amount_received_in_bank' => $this->exit_paper?->date_amount_received_in_bank,
            'vcc_attachment' => $this->vcc_attachment,
            'bill_of_entry_attachment' => $this->bill_of_entry_attachment,
            'other_attachment' => $this->other_attachment,
        ];
    }
}
