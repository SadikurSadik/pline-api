<?php

namespace App\Filters;

use Closure;

class FilterByShortCode extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'short_code', $data['short_code'] ?? null);

        return $next($query);
    }
}
