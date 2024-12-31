<?php

namespace App\Filters;

use Closure;

class FilterByTowingRateGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['rate', 'rate_a', 'rate_b'], $data['global_search'] ?? null);

        return $next($query);
    }
}
