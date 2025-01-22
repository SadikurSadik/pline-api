<?php

namespace App\Filters;

use Closure;

class FilterByLicenseNumber extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'license_number', $data['license_number'] ?? null);

        return $next($query);
    }
}
