<?php

namespace App\Filters;

use Closure;

class FilterByUsername extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'username', $data['username'] ?? null);

        return $next($query);
    }
}
