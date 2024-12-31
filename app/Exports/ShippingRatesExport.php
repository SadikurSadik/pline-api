<?php

namespace App\Exports;

use App\Services\ShippingRateService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShippingRatesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(ShippingRateService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'AMOUNT',
            'AMOUNT 40FEET',
            'AMOUNT 45FEET',
            'FROM COUNTRY',
            'FROM STATE',
            'FROM PORT',
            'TO COUNTRY',
            'TO STATE',
            'TO PORT',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->amount,
            $row->amount_40feet,
            $row->amount_45feet,
            data_get($row, 'from_country.name'),
            data_get($row, 'from_state.name'),
            data_get($row, 'from_port.name'),
            data_get($row, 'to_country.name'),
            data_get($row, 'to_state.name'),
            data_get($row, 'to_port.name'),
            $row->status->getLabel(),
        ];
    }
}
