<?php

namespace App\Filters;

use Closure;

class FilterByAccountName extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'account_name', $data['account_name'] ?? null);

        return $next($query);
    }
}
