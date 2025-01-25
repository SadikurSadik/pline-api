<?php

namespace App\Exports;

use App\Services\LocationService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LocationsExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(LocationService::class)->all(array_merge(
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
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->country?->name,
            $row->state?->name,
            $row->status->getLabel(),
        ];
    }
}
