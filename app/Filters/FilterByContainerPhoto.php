<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Arr;

class FilterByContainerPhoto extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        $value = Arr::get($data, 'photos');
        if ($value === 'yes') {
            $query->whereHas('container_photos');
        } elseif ($value === 'no') {
            $query->whereDoesntHave('container_photos');
        }

        return $next($query);
    }
}
