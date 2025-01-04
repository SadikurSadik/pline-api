<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

class FilterByReceivedDateOnExitPaperRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['exit_paper_received_date'])) {
            $query->whereHas('exit_paper', function ($query) use ($data) {
                if (Str::contains($data['exit_paper_received_date'] ?? '', ' to ')) {
                    $range = dateRangeToDateTimeRange(explode(' to ', $data['exit_paper_received_date']));
                    $this->whereDateBetweenFilter($query, 'received_date', $range);
                } elseif (! empty($data['exit_paper_received_date'])) {
                    $this->whereFilter($query, 'received_date', $data['exit_paper_received_date']);
                }
            });
        }

        return $next($query);
    }
}
