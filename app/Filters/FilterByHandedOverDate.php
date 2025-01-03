<?php

namespace App\Filters;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Str;

class FilterByHandedOverDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if( Str::contains(' to ', $data['handed_over_date'] ?? '')) {
            $range = dateRangeToDateTimeRange(explode(' to ', $data['handed_over_date']));
            $this->whereBetweenFilter($query, 'handed_over_at', $range);
        } elseif (! empty($data['handed_over_date'])) {
            $this->whereFilter($query, 'handed_over_at', $data['handed_over_date']);
        }

        return $next($query);
    }
}
