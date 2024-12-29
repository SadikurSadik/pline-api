<?php

namespace App\Exports;

use App\Services\PortService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PortsExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(PortService::class)->all(array_merge(
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
            data_get($row, 'country.name'),
            data_get($row, 'state.name'),
            $row->status->getLabel(),
        ];
    }
}
