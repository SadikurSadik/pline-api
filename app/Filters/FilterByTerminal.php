<?php

namespace App\Filters;

use Closure;

class FilterByTerminal extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'terminal', $data['terminal'] ?? null);

        return $next($query);
    }
}
