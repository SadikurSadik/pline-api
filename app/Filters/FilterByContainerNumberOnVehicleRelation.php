<?php

namespace App\Filters;

use Closure;

class FilterByContainerNumberOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $query->whereHas('vehicle', function ($query) use ($data) {
            $this->whereFilter($query, 'container_number', $data['container'] ?? null);
        });

        return $next($query);
    }
}
