<?php

namespace App\Filters;

use Closure;

class FilterByCarFaxGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['vin', 'lot_number'], $data['global_search'] ?? null);

        return $next($query);
    }
}
