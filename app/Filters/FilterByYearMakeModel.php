<?php

namespace App\Filters;

use Closure;

class FilterByYearMakeModel extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['year', 'make', 'model'], $data['title'] ?? null);

        return $next($query);
    }
}
