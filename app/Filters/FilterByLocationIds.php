<?php

namespace App\Filters;

use Closure;

class FilterByLocationIds extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $query->whereIn('location_id', $data['location_ids'] ?? []);

        return $next($query);
    }
}
