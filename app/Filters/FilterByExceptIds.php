<?php

namespace App\Filters;

use Closure;

class FilterByExceptIds extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $query->whereNotIn('id', $data['except_ids']);

        return $next($query);
    }
}
