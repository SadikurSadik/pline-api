<?php

namespace App\Filters;

use Closure;

class FilterByToPort extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'to_port_id', $data['to_port_id'] ?? null);

        return $next($query);
    }
}
