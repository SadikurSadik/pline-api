<?php

namespace App\Filters;

use Closure;

class FilterByLocationIds extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (!empty($data['location_ids'])){
            $query->whereIn('location_id', $data['location_ids']);
        }

        return $next($query);
    }
}
