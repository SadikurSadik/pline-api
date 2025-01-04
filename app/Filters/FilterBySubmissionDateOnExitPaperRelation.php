<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

class FilterBySubmissionDateOnExitPaperRelation extends BaseFilter
{
    public function handle($query, Closure $next, $data)
    {
        if (! empty($data['submission_date'])) {
            $query->whereHas('exit_paper', function ($query) use ($data) {
                if (Str::contains($data['submission_date'] ?? '', ' to ')) {
                    $range = dateRangeToDateTimeRange(explode(' to ', $data['submission_date']));
                    $this->whereDateBetweenFilter($query, 'submission_date', $range);
                } elseif (! empty($data['submission_date'])) {
                    $this->whereFilter($query, 'submission_date', $data['submission_date']);
                }
            });
        }

        return $next($query);
    }
}
