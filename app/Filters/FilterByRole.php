<?php

namespace App\Filters;

use Closure;

class FilterByRole extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'role_id', $data['role_id'] ?? null);

        return $next($query);
    }
}
