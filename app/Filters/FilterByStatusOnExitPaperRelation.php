<?php

namespace App\Filters;

use Closure;

class FilterByStatusOnExitPaperRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['exit_paper_status'])) {
            $query->whereHas('exit_paper', function ($query) use ($data) {
                $this->whereFilter($query, 'status', $data['exit_paper_status']);
            });
        }

        return $next($query);
    }
}
