<?php

namespace App\Filters;

use Closure;

class FilterByAuctionName extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'auction_name', $data['auction_name'] ?? null);

        return $next($query);
    }
}
