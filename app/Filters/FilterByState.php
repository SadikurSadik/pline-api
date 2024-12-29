<?php

namespace App\Filters;

use Closure;

class FilterByState extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'state_id', $data['state_id'] ?? null);

        return $next($query);
    }
}
