<?php

namespace App\Filters;

use Closure;

class FilterByCountryOnStateRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['country_id'])) {
            $query->whereHas('state', function ($query) use ($data) {
                $this->whereFilter($query, 'country_id', $data['country_id'] ?? null);
            });
        }

        return $next($query);
    }
}
