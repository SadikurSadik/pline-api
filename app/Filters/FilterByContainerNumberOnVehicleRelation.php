<?php

namespace App\Filters;

use Closure;

class FilterByContainerNumberOnVehicleRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['container'])) {
            $query->whereHas('vehicle.container', function ($query) use ($data) {
                $this->whereFilter($query, 'container_number', $data['container']);

            });
        }

        return $next($query);
    }
}
