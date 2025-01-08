<?php

namespace App\Filters;

use Closure;

class FilterByLotNumberOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if(!empty($data['lot_number'])) {
            $query->whereHas('vehicle', function ($query) use ($data) {
                $this->whereFilter($query, 'lot_number', $data['lot_number']);
            });
        }

        return $next($query);
    }
}
