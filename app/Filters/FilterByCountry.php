<?php

namespace App\Filters;

use Closure;

class FilterByCountry extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'country_id', $data['country_id'] ?? null);

        return $next($query);
    }
}
