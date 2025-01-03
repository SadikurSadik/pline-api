<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

class FilterByReceivedDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if( Str::contains(' to ', $data['received_date'] ?? '')) {
            $range = dateRangeToDateTimeRange(explode(' to ', $data['received_date']));
            $this->whereBetweenFilter($query, 'received_date', $range);
        } elseif (! empty($data['received_date'])) {
            $this->likeFilter($query, 'received_date', $data['received_date']);
        }

        return $next($query);
    }
}
