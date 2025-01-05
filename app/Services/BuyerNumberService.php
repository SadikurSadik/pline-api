<?php

namespace App\Services;

use App\Filters\FilterByAccountName;
use App\Filters\FilterByAuctionName;
use App\Filters\FilterByBuyerId;
use App\Filters\FilterByBuyerNumberGlobalSearch;
use App\Filters\FilterByCompanyName;
use App\Filters\FilterByGradeName;
use App\Filters\FilterByNote;
use App\Filters\FilterByPassword;
use App\Filters\FilterByStatus;
use App\Filters\FilterByUsername;
use App\Models\BuyerNumber;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class BuyerNumberService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = BuyerNumber::with(['sheet', 'grade', 'buyer_customers.customer'])
            ->withCount('vehicles');

        return app(FilterPipelineService::class)->apply($query, [
            FilterByBuyerId::class,
            FilterByUsername::class,
            FilterByPassword::class,
            FilterByAuctionName::class,
            FilterByGradeName::class,
            FilterByAccountName::class,
            FilterByCompanyName::class,
            FilterByNote::class,
            FilterByStatus::class,
            FilterByBuyerNumberGlobalSearch::class,
        ], $filters);
    }

    public function getById($id)
    {
        return BuyerNumber::with([
            'buyer_customers.customer',
            'sheet',
            'grade',
        ])->withCount('vehicles')->findOrFail($id);
    }

    public function destroy($id): void
    {
        $buyerNumber = BuyerNumber::findOrFail($id);
        $buyerNumber->delete();
    }
}
