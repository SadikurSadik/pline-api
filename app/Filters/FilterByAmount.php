<?php

namespace App\Filters;

use Closure;

class FilterByAmount extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'amount', $data['amount'] ?? null);

        return $next($query);
    }
}
