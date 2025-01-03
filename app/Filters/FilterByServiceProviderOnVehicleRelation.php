<?php

namespace App\Filters;

use Closure;

class FilterByServiceProviderOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $query->whereHas('vehicle', function ($query) use ($data) {
            $this->whereFilter($query, 'service_provider', $data['service_provider'] ?? null);
        });

        return $next($query);
    }
}
