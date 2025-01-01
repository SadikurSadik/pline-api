<?php

namespace App\Filters;

use Closure;

class FilterByContainerGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['container_number', 'booking_number', 'terminal'], $data['global_search'] ?? null);

        return $next($query);
    }
}
