<?php

namespace App\Filters;

use Closure;

class FilterBySheetGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['name', 'status'], $data['global_search'] ?? null);

        return $next($query);
    }
}
