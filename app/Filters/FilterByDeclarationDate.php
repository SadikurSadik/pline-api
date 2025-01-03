<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

class FilterByDeclarationDate extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if( Str::contains(' to ', $data['declaration_date'] ?? '')) {
            $range = dateRangeToDateTimeRange(explode(' to ', $data['declaration_date']));
            $this->whereBetweenFilter($query, 'declaration_date', $range);
        } elseif (! empty($data['declaration_date'])) {
            $this->likeFilter($query, 'declaration_date', $data['declaration_date']);
        }

        return $next($query);
    }
}
