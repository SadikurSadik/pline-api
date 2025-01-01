<?php

namespace App\Filters;

use Closure;

class FilterByEtaDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $dateRange = explode(' to ', $data['eta_date'] ?? null);
        $this->whereBetweenFilter($query, 'eta_date', $dateRange);

        return $next($query);
    }
}
