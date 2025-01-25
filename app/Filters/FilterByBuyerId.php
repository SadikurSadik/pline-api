<?php

namespace App\Filters;

use Closure;

class FilterByBuyerId extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'buyer_id', $data['buyer_id'] ?? null);

        return $next($query);
    }
}
