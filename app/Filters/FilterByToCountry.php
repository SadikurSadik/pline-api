<?php

namespace App\Filters;

use Closure;

class FilterByToCountry extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'to_country_id', $data['to_country_id'] ?? null);

        return $next($query);
    }
}
