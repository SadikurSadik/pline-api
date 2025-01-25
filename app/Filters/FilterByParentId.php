<?php

namespace App\Filters;

use Closure;

class FilterByParentId extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'parent_id', $data['parent_id'] ?? null);

        return $next($query);
    }
}
