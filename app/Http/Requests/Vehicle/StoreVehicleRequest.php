<?php

namespace App\Http\Requests\Vehicle;

use App\Enums\BooleanStatus;
use App\Enums\VehicleStatus;
use App\Enums\VehicleTowBy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreVehicleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_user_id' => 'required|integer',
            'vin_number' => [
                'required',
                Rule::unique('vehicles')->where('deleted_at'),
            ],
            'year' => 'required|integer|digits:4',
            'make' => 'required|max:150',
            'model' => 'required|max:150',
            'color' => 'required|max:50',
            'value' => 'required|numeric|min:0|max:99999999',
            'service_provider' => 'nullable|max:100',
            'auction_name' => 'nullable|max:100',
            'weight' => 'nullable|max:50',
            'license_number' => 'nullable|max:30',
            'check_number' => 'nullable|max:30',
            'purchase_date' => 'nullable|date',
            'towed_from' => 'nullable',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'location_id' => 'required|integer',
            'title_amount' => 'nullable|numeric|min:0',
            'storage_amount' => 'nullable|numeric|min:0',
            'additional_charges' => 'nullable|numeric|min:0',
            'condition' => ['nullable', Rule::in(0, 1, true, false)],
            'damaged' => ['nullable', Rule::in(0, 1, true, false)],
            'pictures' => ['nullable', Rule::in(0, 1, true, false)],
            'keys' => ['nullable', Rule::in(0, 1, true, false)],
            'towed' => ['nullable', Rule::in(0, 1, true, false)],
            'title_received' => ['nullable', Rule::in(0, 1, true, false)],
            'title_received_date' => 'nullable|date',
            'title_number' => 'nullable|numeric',
            'title_state' => 'nullable|max:50',
            'towing_request_date' => 'nullable|date',
            'pickup_date' => 'nullable|date',
            'deliver_date' => 'nullable|date',
            'tow_by' => ['nullable', new Enum(VehicleTowBy::class)],
            'tow_fee' => 'nullable|numeric',
            'title_type' => 'nullable|integer',
            'title_type_id' => 'nullable|integer',
            'note' => 'nullable|max:300',
            'vehicle_features' => 'nullable|array',
            'vehicle_conditions' => 'nullable|array',
            'status' => ['nullable', new Enum(VehicleStatus::class)],
            'file_urls' => 'required|array',
            'file_urls.yard_photos.*' => 'nullable|url',
            'file_urls.auction_photos.*' => 'nullable|url',
            'file_urls.pickup_photos.*' => 'nullable|url',
            'file_urls.arrived_photos.*' => 'nullable|url',
            'file_urls.documents.*' => 'nullable|url',
            'file_urls.invoices.*' => 'nullable|url',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_user_id.required' => 'The customer field is required.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_id.required' => 'The city field is required.',
            'location_id.required' => 'The location field is required.',
        ];
    }
}
