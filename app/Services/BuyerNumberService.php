<?php

namespace App\Services;

use App\Filters\FilterByName;
use App\Filters\FilterByShortCode;
use App\Filters\FilterByStatus;
use App\Models\BuyerNumber;
use App\Models\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class BuyerNumberService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = BuyerNumber::with(['sheet','grade','vehicles','buyer_customers.customer']);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
        ], $filters);
    }

}
