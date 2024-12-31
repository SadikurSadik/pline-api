<?php

namespace App\Filters;

use Closure;

class FilterByRateB extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'rate_b', $data['rate_b'] ?? null);

        return $next($query);
    }
}
