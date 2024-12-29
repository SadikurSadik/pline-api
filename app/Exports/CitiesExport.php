<?php

namespace App\Exports;

use App\Services\CityService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitiesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(CityService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'NAME',
            'COUNTRY',
            'STATE',
            'SHORT CODE',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            data_get($row, 'state.country.name'),
            data_get($row, 'state.name'),
            $row->short_code,
            $row->status->getLabel(),
        ];
    }
}
