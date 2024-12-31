<?php

namespace App\Filters;

use Closure;

class FilterByFromCountry extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'from_country_id', $data['from_country_id'] ?? null);

        return $next($query);
    }
}
