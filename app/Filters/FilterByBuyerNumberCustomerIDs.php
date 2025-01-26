<?php

namespace App\Filters;

use Closure;

class FilterByBuyerNumberCustomerIDs extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $customerUserIds = isset($data['customer_user_ids']) && is_string($data['customer_user_ids'])
            ? explode(',', $data['customer_user_ids'])
            : (is_array($data['customer_user_ids']) ? $data['customer_user_ids'] : []);

        if (!empty($customerUserIds)) {
            $query->whereHas('buyer_customers', function ($q) use ($customerUserIds) {
                $q->whereIn('customer_id', $customerUserIds);
            });
        }

        return $next($query);
    }
}
