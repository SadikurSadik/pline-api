<?php

namespace App\Filters;

use Closure;

class FilterByVccGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['declaration_date', function ($query, $value) {
            $query->orWhereHas('vehicle', function ($query) use ($value) {
                $this->orFilter($query, ['vin_number', 'lot_number'], $value);
            });
        }], $data['global_search'] ?? null);

        return $next($query);
    }
}
