<?php

namespace App\Filters;

use Closure;

class FilterByVinNumber extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'vin_number', $data['vin_number'] ?? null);

        return $next($query);
    }
}
