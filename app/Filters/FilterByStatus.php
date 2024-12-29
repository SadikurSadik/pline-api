<?php

namespace App\Filters;

use Closure;

class FilterByStatus extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->whereFilter($query, 'status', $data['status'] ?? null);
        if (! empty($data['status_id'])) {
            $this->whereFilter($query, 'status', $data['status_id']);
        }

        return $next($query);
    }
}
