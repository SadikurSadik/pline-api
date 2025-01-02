<?php

namespace App\Http\Requests\Container;

use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateContainerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_user_id' => 'required|integer',
            'vehicle_ids' => 'required|array|min:1',
            'booking_number' => [
                'required',
                'max:30',
                Rule::unique('containers')->where('deleted_at')->ignore($this->route()->container),
            ],
            'container_number' => 'nullable|max:30',
            'seal_number' => 'nullable|max:30',
            'vessel' => 'nullable|max:50',
            'voyage' => 'nullable|max:50',
            'streamship_line' => 'nullable|string|max:150',
            'xtn_number' => 'nullable|max:30',
            'itn' => 'nullable|max:30',
            'broker_name' => 'nullable|max:100',
            'oti_number' => 'nullable|max:30',
            'terminal' => 'nullable|max:50',
            'destination' => 'nullable|max:80',
            'ar_number' => 'nullable|max:50',
            'loading_date' => 'nullable|date',
            'cut_off_date' => 'nullable|date',
            'export_date' => 'nullable|date',
            'eta_date' => 'nullable|date',
            'arrival_date' => 'nullable|date',
            'contact_detail' => 'nullable|max:300',
            'special_instruction' => 'nullable|max:300',
            'bol_note' => 'nullable|max:200',
            'port_of_loading_country_id' => 'required|integer',
            'port_of_loading_state_id' => 'required|integer',
            'port_of_loading_id' => 'required|integer',
            'port_of_discharge_country_id' => 'required|integer',
            'port_of_discharge_state_id' => 'required|integer',
            'port_of_discharge_id' => 'required|integer',
            'container_type' => ['nullable', new Enum(ContainerType::class)],
            'status' => ['nullable', new Enum(ContainerStatus::class)],
            'file_urls' => 'required|array',
            'file_urls.container_photos.*' => 'nullable|url',
            'file_urls.empty_container_photos.*' => 'nullable|url',
            'file_urls.loading_photos.*' => 'nullable|url',
            'file_urls.loaded_photos.*' => 'nullable|url',
            'file_urls.documents.*' => 'nullable|url',

            // dock receipt
            'awb_number' => 'nullable|max:50',
            'export_reference' => 'nullable|max:100',
            'forwarding_agent' => 'nullable|max:200',
            'domestic_routing_instructions' => 'nullable|max:250',
            'pre_carriage_by' => 'nullable|max:100',
            'place_of_receipt_by_pre_carrier' => 'nullable|max:50',
            'exporting_carrier' => 'nullable|max:100',
            'final_destination' => 'nullable|max:100',
            'loading_terminal' => 'nullable|max:100',
            'dock_container_type' => 'nullable|max:100',
            'number_of_packages' => 'nullable|max:100',
            'by' => 'nullable|max:100',
            'date' => 'nullable|date',
            'auto_receiving_date' => 'nullable|date',
            'auto_cut_off' => 'nullable|date',
            'vessel_cut_off' => 'nullable|date',
            'sale_date' => 'nullable|date',

            // houstan custom cover letter
            'vehicle_location' => 'nullable|max:45',
            'exporter_id' => 'nullable|max:45',
            'exporter_type_issuer' => 'nullable|max:45',
            'transportation_value' => 'nullable|max:45',
            'exporter_dob' => 'nullable|max:45',
            'ultimate_consignee_dob' => 'nullable|max:45',
            'consignee_id' => 'nullable|integer',
            'notify_party' => 'nullable|integer',
            'manifest_consignee' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_user_id' => 'The customer field is required.',
            'vehicle_ids' => 'The vehicle field is required.',
            'port_of_loading_id' => 'The port of loading field is required.',
            'port_of_discharge_id' => 'The port of discharge field is required.',
            'port_of_loading_country_id' => 'The port of loading country field is required.',
            'port_of_loading_state_id' => 'The port of loading state field is required.',
            'port_of_discharge_country_id' => 'The port of discharge country field is required.',
            'port_of_discharge_state_id' => 'The port of discharge state field is required.',
        ];
    }
}
