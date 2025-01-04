<?php

namespace App\Filters;

use Closure;

class FilterByLotNumberOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $query->whereHas('vehicle', function ($query) use ($data) {
            $this->whereFilter($query, 'lot_number', $data['lot_number'] ?? null);
        });

        return $next($query);
    }
}
