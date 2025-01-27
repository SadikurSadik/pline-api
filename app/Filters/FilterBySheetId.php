<?php

namespace App\Filters;

use Closure;

class FilterBySheetId extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $this->likeFilter($query, 'sheet_id', $data['sheet_id'] ?? null);

        return $next($query);
    }
}
