<?php

namespace App\Filters;

use Closure;

class FilterByVinNumberOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if(!empty($data['vin_number'])){
            $query->whereHas('vehicle', function ($query) use ($data) {
                $this->whereFilter($query, 'vin_number', $data['vin_number'] ?? null);
            });
        }

        return $next($query);
    }
}
