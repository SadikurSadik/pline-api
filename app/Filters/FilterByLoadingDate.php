<?php

namespace App\Filters;

use Closure;

class FilterByLoadingDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $dateRange = explode(' to ', $data['loading_date'] ?? null);
        $this->whereBetweenFilter($query, 'loading_date', $dateRange);

        return $next($query);
    }
}
