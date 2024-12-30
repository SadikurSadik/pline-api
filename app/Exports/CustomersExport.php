<?php

namespace App\Exports;

use App\Services\CustomerService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(CustomerService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'NAME',
            'COMPANY NAME',
            'USERNAME',
            'EMAIL',
            'PHONE',
            'COUNTRY NAME',
            'STATE NAME',
            'CITY NAME',
            'ADDRESS',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->company_name,
            $row->user?->username,
            $row->user?->email,
            $row->phone,
            data_get($row, 'country.name'),
            data_get($row, 'state.name'),
            data_get($row, 'city.name'),
            $row->address,
            ! empty($row->user) ? $row->user->status->getLabel() : '',
        ];
    }
}
