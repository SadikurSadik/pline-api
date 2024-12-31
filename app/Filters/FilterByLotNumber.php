<?php

namespace App\Filters;

use Closure;

class FilterByLotNumber extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'lot_number', $data['lot_number'] ?? null);

        return $next($query);
    }
}
