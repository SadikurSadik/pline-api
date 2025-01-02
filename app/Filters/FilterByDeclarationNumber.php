<?php

namespace App\Filters;

use Closure;

class FilterByDeclarationNumber extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'declaration_number', $data['declaration_number'] ?? null);

        return $next($query);
    }
}
