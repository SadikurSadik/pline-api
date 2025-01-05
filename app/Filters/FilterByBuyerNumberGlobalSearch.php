<?php

namespace App\Filters;

use Closure;

class FilterByBuyerNumberGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['buyer_id', 'username', 'password', 'account_name'], $data['global_search'] ?? null);

        return $next($query);
    }
}
