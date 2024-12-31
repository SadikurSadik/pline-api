<?php

namespace App\Filters;

use Closure;

class FilterByPurchaseDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $dateRange = explode(' to ', $data['purchase_date'] ?? null);
        $this->whereBetweenFilter($query, 'purchase_date', $dateRange);

        return $next($query);
    }
}
