<?php

namespace App\Exports;

use App\Services\DamageClaimService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DamageClaimsExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(DamageClaimService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'VIN',
            'CUSTOMER NAME',
            'DESCRIPTION',
            'CLAIM AMOUNT',
            'APPROVED AMOUNT',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->vehicle?->vin_number,
            data_get($row, 'customer.name'),
            $row->description,
            $row->claim_amount,
            $row->approved_amount,
            $row->status?->getLabel(),
        ];
    }
}
