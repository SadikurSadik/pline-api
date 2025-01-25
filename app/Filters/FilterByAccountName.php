<?php

namespace App\Filters;

use Closure;

class FilterByAccountName extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'name_on_the_account', $data['name_on_the_account'] ?? null);

        return $next($query);
    }
}
