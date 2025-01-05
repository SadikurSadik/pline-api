<?php

namespace App\Filters;

use Closure;

class FilterBySubject extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'subject', $data['subject'] ?? null);

        return $next($query);
    }
}
