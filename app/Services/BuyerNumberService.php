<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
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
use App\Models\CustomerBuyerNumber;
use Carbon\Carbon;
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

    public function store(array $data): void
    {
        $this->save($data);
    }

    public function update(array $data, int $id)
    {
        return $this->save($data, $id);
    }

    public function save(array $data, ?int $id = null)
    {
        $buyerNumber = BuyerNumber::findOrNew($id);

        $customer_ids = [];
        if (isset($data['customer_user_ids'])) {
            $customer_ids = $data['customer_user_ids'];
            unset($data['customer_user_ids']);
        }

        $buyerNumber->status = $data['status'] ?? VisibilityStatus::INACTIVE;
        $buyerNumber->fill($data);
        $buyerNumber->save();

        $this->customerAssign($customer_ids, $buyerNumber->id, $id);

        return $buyerNumber;
    }

    private function customerAssign($customer_ids, $buyer_number_id, $id): void
    {
        if (! $id) {
            $this->customerBuyerNumberCreate($customer_ids, $buyer_number_id);
        } else {
            $assigned_customer_ids = CustomerBuyerNumber::where('buyer_number_id', $buyer_number_id)
                ->where('unassigned_at', null)
                ->pluck('customer_id')
                ->toArray();

            $newAssignedCustomer = array_diff($customer_ids, $assigned_customer_ids);
            $unAssignedCustomer = array_diff($assigned_customer_ids, $customer_ids);

            $this->customerBuyerNumberCreate($newAssignedCustomer, $buyer_number_id);
            $this->customerBuyerNumberCreate($unAssignedCustomer, $buyer_number_id, 'update');
        }
    }

    public function customerBuyerNumberCreate($customer_ids, $buyer_number_id, $insertType = 'create'): void
    {
        foreach ($customer_ids as $customer_id) {
            if ($insertType == 'create') {
                CustomerBuyerNumber::create(
                    [
                        'customer_id' => $customer_id,
                        'buyer_number_id' => $buyer_number_id,
                        'assigned_at' => Carbon::now(),
                    ]
                );
            } elseif ($insertType == 'update') {
                CustomerBuyerNumber::where([
                    'customer_id' => $customer_id,
                    'buyer_number_id' => $buyer_number_id,
                ])->update(['unassigned_at' => Carbon::now()]);
            }
        }
    }
}