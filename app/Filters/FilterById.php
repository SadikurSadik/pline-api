<?php

namespace App\Filters;

use Closure;

class FilterById extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'id', $data['id'] ?? null);

        return $next($query);
    }
}
