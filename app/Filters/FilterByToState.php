<?php

namespace App\Filters;

use Closure;

class FilterByToState extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'to_state_id', $data['to_state_id'] ?? null);

        return $next($query);
    }
}
