<?php

namespace App\Filters;

use Closure;

class FilterByReceivedDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'received_date', $data['received_date'] ?? null);

        return $next($query);
    }
}
