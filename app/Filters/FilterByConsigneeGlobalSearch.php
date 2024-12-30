<?php

namespace App\Filters;

use Closure;

class FilterByConsigneeGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['name', 'phone'], $data['global_search'] ?? null);

        return $next($query);
    }
}
