<?php

namespace App\Exports;

use App\Services\VccService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VccsExport implements FromQuery, WithHeadings, WithMapping
{
    private $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function headings(): array
    {
        return [
            'CUSTOMER NAME',
            'YEAR'.PHP_EOL.'MODEL'.PHP_EOL.'MAKE',
            'VIN',
            'SHIPPING INVOICE',
            'SERVICE PROVIDER',
            'CONTAINER NUMBER',
            'CONTAINER ARRIVED DATE',
            'DECLARATION NUMBER',
            'DECLARATION DATE',
            'VCC STATUS',
            'VCC RECEIVED DATE'.PHP_EOL.'HANDED OVER DATE AND TIME',
            'HANDED OVER TO',
            'VCC DEPOSIT'.PHP_EOL.'DEPOSIT REFUNDED',
            'EXIT PAPER RECEIVED DATE AND TIME',
            'EXIT PAPER STATUS',
            'EXIT PAPER SUBMISSION DATE',
            'CUSTOM DUTY AMOUNT',
            'RECEIVABLE CLAIM AMOUNT',
            'AMOUNT RECEIVED BANK',
            'AMOUNT RECEIVED BANK DATE',
        ];
    }

    public function map($row): array
    {
        return [
            data_get($row, 'vehicle.customer.customer_name'),
            data_get($row, 'vehicle.year').PHP_EOL.data_get($row, 'vehicle.make').PHP_EOL.data_get($row, 'vehicle.model'),
            data_get($row, 'vehicle.vin_number'),
            'null',
            data_get($row, 'vehicle.service_provider'),
            data_get($row, 'container.container_number'),
            data_get($row, 'container.arrival_date'),
            $row->declaration_number,
            $row->declaration_date,
            $row->status,
            dateFormat($row->received_date).PHP_EOL.dateTimeFormat($row->handed_over_at),
            $row->handed_over_to,
            amountFormat($row->deposit_amount).PHP_EOL.amountFormat($row->exit_paper?->refund_amount),
            dateTimeFormat($row->exit_paper?->received_at),
            $row->exit_paper?->status,
            dateFormat($row->exit_paper?->submission_date),
            amountFormat($row->custom_duty),
            amountFormat($row->exit_paper?->receivable_claim_amount),
            amountFormat($row->exit_paper?->amount_received_in_bank),
            dateFormat($row->exit_paper?->date_amount_received_in_bank),
        ];
    }

    public function query()
    {
        return app(VccService::class)->all(array_merge($this->filters, ['limit' => -1, 'query_only' => true]));
    }
}
