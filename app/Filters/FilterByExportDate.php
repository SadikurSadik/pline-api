<?php

namespace App\Filters;

use Closure;

class FilterByExportDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $dateRange = explode(' to ', $data['export_date'] ?? null);
        $this->whereBetweenFilter($query, 'export_date', $dateRange);

        return $next($query);
    }
}
