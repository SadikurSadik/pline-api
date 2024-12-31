<?php

namespace App\Filters;

use Closure;

class FilterByAmountGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'amount', $data['global_search'] ?? null);

        return $next($query);
    }
}
