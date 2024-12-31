<?php

namespace App\Filters;

use Closure;

class FilterByVehicleGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['vin_number', 'lot_number'], $data['global_search'] ?? null);

        return $next($query);
    }
}
