<?php

namespace App\Filters;

use Closure;

class FilterByName extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'name', $data['name'] ?? null);

        return $next($query);
    }
}
