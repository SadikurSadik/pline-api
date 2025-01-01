<?php

namespace App\Exports;

use App\Services\CarFaxService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CarFaxesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(CarFaxService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'LOT NUMBER',
            'VIN',
            'REQUESTED BY',
            'YEAR',
            'MAKE',
            'MODEL',
            'COLOR',
            'NOTE',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->lot_number,
            $row->vin,
            'N/A',
            $row->year,
            $row->make,
            $row->model,
            $row->color,
            $row->note,
            $row->status?->getLabel(),
        ];
    }
}
