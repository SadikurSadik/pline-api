<?php

namespace App\Exports;

use App\Services\TitleTypeService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TitleTypesExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(TitleTypeService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'NAME',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->status->getLabel(),
        ];
    }
}
