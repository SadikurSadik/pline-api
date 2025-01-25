<?php

namespace App\Filters;

use Closure;

class FilterByHandedOverTo extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'handed_over_to', $data['handed_over_to'] ?? null);

        return $next($query);
    }
}
