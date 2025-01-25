<?php

namespace App\Exports;

use App\Services\ExportRateService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportRatesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(ExportRateService::class)->all(array_merge(
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
            'FROM COUNTRY',
            'TO COUNTRY',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->rate,
            $row->rate_a,
            $row->rate_b,
            data_get($row, 'from_country.name'),
            data_get($row, 'to_country.name'),
            $row->status?->getLabel(),
        ];
    }
}
