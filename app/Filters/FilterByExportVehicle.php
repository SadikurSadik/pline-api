<?php

namespace App\Filters;

use Closure;

class FilterByExportVehicle extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'export_vehicle', $data['export_vehicle'] ?? null);

        return $next($query);
    }
}
