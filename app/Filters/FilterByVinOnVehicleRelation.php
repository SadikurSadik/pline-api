<?php

namespace App\Filters;

use Closure;

class FilterByVinOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['global_search'])) {
            $query->whereHas('vehicle', function ($query) use ($data) {
                $this->likeFilter($query, 'vin_number', $data['global_search'] ?? null);
            });
        }

        return $next($query);
    }
}
