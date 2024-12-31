<?php

namespace App\Filters;

use Closure;

class FilterByCity extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'city_id', $data['city_id'] ?? null);

        return $next($query);
    }
}
