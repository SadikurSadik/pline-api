<?php

namespace App\Exports;

use App\Services\ConsigneeService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ConsigneesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(ConsigneeService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'NAME',
            'CUSTOMER NAME',
            'PHONE',
            'COUNTRY NAME',
            'STATE NAME',
            'CITY NAME',
            'ADDRESS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            data_get($row, 'customer.name'),
            $row->phone,
            data_get($row, 'country.name'),
            data_get($row, 'state.name'),
            data_get($row, 'city.name'),
            $row->address,
        ];
    }
}
