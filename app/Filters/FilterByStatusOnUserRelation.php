<?php

namespace App\Filters;

use Closure;

class FilterByStatusOnUserRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['status'])) {
            $query->whereHas('user', function ($query) use ($data) {
                $this->whereFilter($query, 'status', $data['status'] ?? null);
            });
        }

        return $next($query);
    }
}
