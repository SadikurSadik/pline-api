<?php

namespace App\Exports;

use App\Services\TowingRateService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TowingRatesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(TowingRateService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'RATE',
            'RATE A',
            'RATE B',
            'COUNTRY',
            'STATE',
            'CITY',
            'LOCATION',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->rate,
            $row->rate_a,
            $row->rate_b,
            data_get($row, 'country.name'),
            data_get($row, 'state.name'),
            data_get($row, 'city.name'),
            data_get($row, 'location.name'),
            $row->status->getLabel(),
        ];
    }
}