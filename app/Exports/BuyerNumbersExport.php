<?php

namespace App\Exports;

use App\Services\BuyerNumberService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BuyerNumbersExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(BuyerNumberService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'BUYER ID',
            'USERNAME',
            'PASSWORD',
            'ACCOUNT NAME',
            'GRADE NAME',
            'AUCTION NAME',
            'COMPANY NAME',
            'ASSIGNED CUSTOMER',
            'NOTE',
            'TOTAL VEHICLE',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        return [
            $row->buyer_id,
            $row->username,
            $row->password,
            $row->account_name,
            data_get($row, 'grade.name'),
            $row->name_on_the_account,
            $row->company_name,
            $row->buyer_customers?->pluck('customer.name')?->implode(', '),
            $row->note,
            $row->vehicles_count,
            $row->status->getLabel(),
        ];
    }
}
