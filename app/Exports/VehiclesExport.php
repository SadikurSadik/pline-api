<?php

namespace App\Exports;

use App\Services\VehicleService;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehiclesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(VehicleService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return array_map('strtoupper', [
            'Year',
            'Make',
            'Model',
            'Color',
            'Vin',
            'Lot Number',
            'Customer Name',
            'Country',
            'State',
            'City',
            'Location',
            'Status',
            'Value',
            'Weight',
            'Purchase Date',
            //            'Hat Number',
            'Auction',
            'Buyer ID',
            'Service Provider',
            'Storage Amount',
            'Keys',
            'Condition',
            'Damaged',
            'Pictures',
            'Towed',
            'Title',
            'Title Number',
            'Title Amount',
            'Title State',
            'Towing Request Date',
            'Title Received Date',
            'Pickup Date',
            'Deliver Date',
            'Tow By',
            'Tow Fee',
            'Title Type',
            'Hand Over Date',
            'Note',
            'Check Number',
            // 'Container Number',
            'Created At',

        ]);
    }

    public function map($row): array
    {
        return [
            $row->year,
            $row->make,
            $row->model,
            $row->color,
            $row->vin_number,
            $row->lot_number,
            data_get($row, 'customer.name'),
            data_get($row, 'country.name'),
            data_get($row, 'state.name'),
            data_get($row, 'city.name'),
            data_get($row, 'location.name'),
            $row->status->getLabel(),
            $row->value,
            $row->weight,
            $row->purchase_date,
            //            $row->hat_number,
            $row->auction_name,
            $row->license_number,
            $row->service_provider,
            $row->storage_amount,
            $row->keys?->getLabel(),
            $row->condition?->getLabel(),
            $row->damaged?->getLabel(),
            $row->pictures?->getLabel(),
            $row->towed?->getLabel(),
            $row->title_received?->getLabel(),
            $row->title_number,
            $row->title_amount,
            $row->title_state,
            $row->towing_request_date,
            $row->title_received_date,
            $row->pickup_date,
            $row->deliver_date,
            $row->tow_by?->getLabel(),
            $row->tow_fee,
            data_get($row, 'title_type.name'),
            $row->handed_over_date,
            $row->note,
            $row->check_number,
            // 'Container Number',
            Carbon::parse($row->created_at)->format('Y-m-d h:i:s'),
        ];
    }
}
