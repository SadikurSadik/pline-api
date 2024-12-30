<?php

namespace App\Filters;

use Closure;

class FilterByCompanyName extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'company_name', $data['company_name'] ?? null);

        return $next($query);
    }
}
