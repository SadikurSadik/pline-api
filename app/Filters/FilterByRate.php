<?php

namespace App\Filters;

use Closure;

class FilterByRate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'rate', $data['rate'] ?? null);

        return $next($query);
    }
}
