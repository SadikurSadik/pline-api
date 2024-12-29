<?php

namespace App\Filters;

use Closure;

class FilterByEmail extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'email', $data['email'] ?? null);

        return $next($query);
    }
}
