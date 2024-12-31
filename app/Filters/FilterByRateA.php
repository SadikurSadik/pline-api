<?php

namespace App\Filters;

use Closure;

class FilterByRateA extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'rate_a', $data['rate_a'] ?? null);

        return $next($query);
    }
}
