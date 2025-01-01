<?php

namespace App\Filters;

use Closure;

class FilterByArrivalDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'arrival_date', $data['arrival_date'] ?? null);

        return $next($query);
    }
}
