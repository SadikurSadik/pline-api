<?php

namespace App\Filters;

use Closure;

class FilterByPassword extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'password', $data['password'] ?? null);

        return $next($query);
    }
}
