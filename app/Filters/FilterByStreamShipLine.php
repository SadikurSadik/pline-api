<?php

namespace App\Filters;

use Closure;

class FilterByStreamShipLine extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'streamship_line', $data['streamship_line'] ?? null);

        return $next($query);
    }
}
