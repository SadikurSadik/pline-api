<?php

namespace App\Filters;

use Closure;

class FilterByContainerNumber extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'container_number', $data['container_number'] ?? null);

        return $next($query);
    }
}
