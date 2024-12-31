<?php

namespace App\Filters;

use Closure;

class FilterByCustomerUser extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'customer_user_id', $data['customer_user_id'] ?? null);
        if (! empty($data['customer_id'])) {
            $query->whereHas('customer', function ($subQuery) use ($data) {
                $subQuery->where('customer_id', $data['customer_id']);
            });
        }

        return $next($query);
    }
}
