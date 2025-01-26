<?php

namespace App\Filters;

use Closure;

class FilterByGradeName extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'grade_id', $data['grade_id'] ?? null);

        return $next($query);
    }
}
