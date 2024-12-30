<?php

namespace App\Filters;

use Closure;

class FilterByCustomerID extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'customer_id', $data['customer_id'] ?? null);

        return $next($query);
    }
}
