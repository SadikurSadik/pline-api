<?php

namespace App\Filters;

use Closure;

class FilterByFromState extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'from_state_id', $data['from_state_id'] ?? null);

        return $next($query);
    }
}
