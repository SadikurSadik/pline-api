<?php

namespace App\Filters;

use Closure;

class FilterByCustomerUserOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $query->whereHas('vehicle', function ($query) use ($data) {
            $this->whereFilter($query, 'customer_user_id', $data['customer_user_id'] ?? null);
        });

        return $next($query);
    }
}
