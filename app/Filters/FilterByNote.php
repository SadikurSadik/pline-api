<?php

namespace App\Filters;

use Closure;

class FilterByNote extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'note', $data['note'] ?? null);

        return $next($query);
    }
}
