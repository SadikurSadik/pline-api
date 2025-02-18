<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

class FilterByEtaDateOnContainerRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['eta_date'])) {
            $query->whereHas('container', function ($query) use ($data) {
                if (Str::contains($data['eta_date'] ?? '', ' to ')) {
                    $range = dateRangeToDateTimeRange(explode(' to ', $data['eta_date']));
                    $this->whereDateBetweenFilter($query, 'eta_date', $range);
                } elseif (! empty($data['eta_date'])) {
                    $this->whereFilter($query, 'eta_date', $data['eta_date']);
                }
            });
        }

        return $next($query);
    }
}
