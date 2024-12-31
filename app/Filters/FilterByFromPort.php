<?php

namespace App\Filters;

use Closure;

class FilterByFromPort extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'from_port_id', $data['from_port_id'] ?? null);

        return $next($query);
    }
}
