<?php

namespace App\Filters;

use Closure;

class FilterByBookingNumber extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'booking_number', $data['booking_number'] ?? null);

        return $next($query);
    }
}
