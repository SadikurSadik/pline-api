<?php

namespace App\Http\Resources\Container;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DockReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'container_id' => $this->container_id,
            'awb_number' => $this->awb_number,
            'export_reference' => $this->export_reference,
            'forwarding_agent' => $this->forwarding_agent,
            'domestic_routing_instructions' => $this->domestic_routing_instructions,
            'pre_carriage_by' => $this->pre_carriage_by,
            'place_of_receipt_by_pre_carrier' => $this->place_of_receipt_by_pre_carrier,
            'exporting_carrier' => $this->exporting_carrier,
            'final_destination' => $this->final_destination,
            'loading_terminal' => $this->loading_terminal,
            'dock_container_type' => $this->dock_container_type,
            'number_of_packages' => $this->number_of_packages,
            'by' => $this->by,
            'date' => $this->date,
            'auto_receiving_date' => $this->auto_receiving_date,
            'auto_cut_off' => $this->auto_cut_off,
            'vessel_cut_off' => $this->vessel_cut_off,
            'sale_date' => $this->sale_date,
        ];
    }
}
