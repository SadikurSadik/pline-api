<?php

namespace App\Filters;

use Closure;

class FilterByCustomerGlobalSearch extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->orFilter($query, ['name', 'company_name', 'phone', function ($query, $value) {
            $query->orWhereHas('user', function ($query) use ($value) {
                $this->orFilter($query, ['username', 'email'], $value);
            });
        }], $data['global_search'] ?? null);

        return $next($query);
    }
}
