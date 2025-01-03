<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

class FilterByArrivedDateOnVehicleContainerRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $query->whereHas('vehicle.container', function ($query) use ($data) {
            if( Str::contains(' to ', $data['arrival_date'] ?? '')) {
                $range = dateRangeToDateTimeRange(explode(' to ', $data['arrival_date']));
                $this->whereBetweenFilter($query, 'arrival_date', $range);
            } elseif (! empty($data['arrival_date'])) {
                $this->whereFilter($query, 'arrival_date', $data['arrival_date']);
            }
        });

        return $next($query);
    }
}
