<?php

namespace App\Filters;

use Closure;

class FilterByPhone extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'phone', $data['phone'] ?? null);

        return $next($query);
    }
}
