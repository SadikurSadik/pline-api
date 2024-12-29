<?php

namespace App\Exports;

use App\Services\CountryService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountriesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(CountryService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'NAME',
            'SHORT CODE',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->short_code,
            $row->status->getLabel(),
        ];
    }
}
