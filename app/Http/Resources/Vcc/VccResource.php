<?php

namespace App\Http\Resources\Vcc;

use App\Enums\VccRegistrationType;
use App\Enums\VccStatus;
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
            'container_id' => $this->container_id,
            'container' => $this->container->container_number,
            'arrival_date' => $this->container->arrival_date,
            'declaration_number' => $this->declaration_number,
            'declaration_date' => $this->declaration_date,
            'status' => $this->status?->value,
            'status_name' => $this->status?->getLabel(),
            'vehicle_registration_type' => $this->vehicle_registration_type?->getLabel(),
            'vcc_received_date' => $this->received_date,
            'hand_over_date' => dateFormat($this->handed_over_at),
            'hand_over_time' => dateTimeFormat($this->handed_over_at),
            'hand_over_to' => $this->handed_over_to,
            'deposit_amount' => $this->deposit_amount,
            'refund_amount' => $this->exit_paper?->refund_amount,
            'exit_paper_received_date' => dateFormat($this->exit_paper?->received_at),
            'exit_paper_received_time' => dateTimeFormat($this->exit_paper?->received_at),
            'exit_paper_status' => $this->exit_paper?->status,
            'exit_paper_submission_date' => dateFormat($this->exit_paper?->submission_date),
            'submission_note' => null,
            'custom_duty_amount' => $this->custom_duty,
            'receivable_claim_amount' => $this->exit_paper?->receivable_claim_amount,
            'amount_received_in_bank' => $this->exit_paper?->amount_received_in_bank,
            'date_amount_received_in_bank' => $this->exit_paper?->date_amount_received_in_bank,
            'vcc_attachment' => $this->vcc_attachment,
            'bill_of_entry_attachment' => $this->bill_of_entry_attachment,
            'other_attachment' => $this->other_attachment,
            'show_receive_exit_paper_button' => $this->showReceiveExitPaperButton(),
            'show_submit_exit_paper_button' => $this->showSubmitExitPaperButton(),
        ];
    }

    private function showReceiveExitPaperButton()
    {
        return $this->status == VccStatus::HANDED_OVER && $this->vehicle_registration_type == VccRegistrationType::EXIT && empty($this->exit_paper);
    }

    private function showSubmitExitPaperButton()
    {
        return $this->status == VccStatus::HANDED_OVER && $this->vehicle_registration_type == VccRegistrationType::EXIT && ! empty($this->exit_paper && $this->exit_paper->status == VccStatus::EXIT_PAPER_RECEIVED);
    }
}
