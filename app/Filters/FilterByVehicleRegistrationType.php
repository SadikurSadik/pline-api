<?php

namespace App\Filters;

use Closure;

class FilterByVehicleRegistrationType extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'vehicle_registration_type', $data['vehicle_registration_type'] ?? null);

        return $next($query);
    }
}
