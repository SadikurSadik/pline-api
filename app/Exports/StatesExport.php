<?php

namespace App\Exports;

use App\Services\StateService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StatesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(StateService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'NAME',
            'COUNTRY',
            'SHORT CODE',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            data_get($row, 'country.name'),
            $row->short_code,
            $row->status->getLabel(),
        ];
    }
}
