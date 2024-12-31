<?php

namespace App\Filters;

use Closure;

class FilterByServiceProvider extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'service_provider', $data['service_provider'] ?? null);

        return $next($query);
    }
}
