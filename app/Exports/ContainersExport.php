<?php

namespace App\Exports;

use App\Services\ContainerService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContainersExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(ContainerService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'CUSTOMER NAME',
            'BOOKING NUMBER',
            'CONTAINER NUMBER',
            'LOADING DATE',
            'EXPORT DATE',
            'ETA DATE',
            'VESSEL',
            'VOYAGE',
            'TERMINAL',
            'STREAMSHIP LINE',
            'DESTINATION',
            'CUT OFF DATE',
            'ITN',
            'CONTAINER TYPE',
            'PORT OF LOADING COUNTRY',
            'PORT OF LOADING STATE',
            'PORT OF LOADING',
            'PORT OF DISCHARGE COUNTRY',
            'PORT OF DISCHARGE STATE',
            'PORT OF DISCHARGE',
            'SEAL NUMBER',
            'XTN NUMBER',
            'BROKER NAME',
            'OTI NUMBER',
            'AR NUMBER',
            'CONTACT DETAIL',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->customer?->name,
            $row->booking_number,
            $row->container_number,
            $row->loading_date,
            $row->export_date,
            $row->eta_date,
            $row->vessel,
            $row->voyage,
            $row->terminal,
            $row->streamship_line,
            $row->destination,
            $row->cut_off_date,
            $row->itn,
            $row->container_type?->getLabel(),
            $row->port_of_loading?->state?->country?->name,
            $row->port_of_loading?->state?->name,
            $row->port_of_loading->name,
            $row->port_of_discharge?->state?->country?->name,
            $row->port_of_discharge?->state?->name,
            $row->port_of_discharge->name,
            $row->seal_number,
            $row->xtn_number,
            $row->broker_name,
            $row->oti_number,
            $row->ar_number,
            $row->contact_detail,
            $row->status->getLabel(),
        ];
    }
}
