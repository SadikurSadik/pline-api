<?php

namespace App\Filters;

use Closure;

class FilterByLocation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'location_id', $data['location_id'] ?? null);

        return $next($query);
    }
}
