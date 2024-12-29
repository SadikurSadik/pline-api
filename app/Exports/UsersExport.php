<?php

namespace App\Exports;

use App\Services\UserService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    private array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return app(UserService::class)->all(array_merge(
            $this->filters,
            ['limit' => -1, 'query_only' => true]
        ));
    }

    public function headings(): array
    {
        return [
            'NAME',
            'USERNAME',
            'EMAIL',
            'ROLE',
            'STATUS',
        ];
    }

    public function map($row): array
    {
        $role = $row->role;

        return [
            $row->name,
            $row->username,
            $row->email,
            $role?->name,
            $row->status->getLabel(),
        ];
    }
}
