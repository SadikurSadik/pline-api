<?php

namespace App\Services;

use App\Enums\Role;
use App\Enums\VehicleStatus;
use App\Enums\VisibilityStatus;
use App\Filters\FilterByCompanyName;
use App\Filters\FilterByCustomerGlobalSearch;
use App\Filters\FilterByCustomerID;
use App\Filters\FilterByName;
use App\Filters\FilterByStatusOnUserRelation;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CustomerService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Customer::with(['user', 'city'])->withCount([
            'vehicles',
            'vehicles as on_hand' => function ($q) {
                $q->where('status', '=', VehicleStatus::ON_HAND->value);
            },
            'vehicles as on_the_way' => function ($q) {
                $q->where('status', '=', VehicleStatus::ON_THE_WAY->value);
            },
            'vehicles as arrived' => function ($q) {
                $q->where('status', '=', VehicleStatus::ARRIVED->value);
            },
        ]);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByName::class,
            FilterByCompanyName::class,
            FilterByCustomerID::class,
            FilterByStatusOnUserRelation::class,
            FilterByCustomerGlobalSearch::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Customer::with(['user', 'country', 'state', 'city', 'consignees'])->find($id);
    }

    public function store(array $data)
    {
        return $this->save($data);
    }

    public function update(int $id, array $data)
    {
        return $this->save($data, $id);
    }

    private function save(array $data, ?int $id = null)
    {
        $data['status'] = Arr::get($data, 'status') == VisibilityStatus::ACTIVE->value ?
            VisibilityStatus::ACTIVE->value : VisibilityStatus::INACTIVE->value;
        $data['block_issue_vcc'] = Arr::get($data, 'block_issue_vcc') == VisibilityStatus::ACTIVE->value ?
            VisibilityStatus::ACTIVE->value : VisibilityStatus::INACTIVE->value;
        $customer = Customer::findOrNew($id);
        $user = User::findOrNew($customer->user_id);
        $user->fill($data);
        $user->role_id = Role::CUSTOMER->value;
        if (! empty($user->profile_photo)) {
            $user->profile_photo = getRelativeUrl($user->profile_photo);
        }
        $user->save();
        $user->syncRolePermissions();

        $customer->fill($data);
        $customer->user_id = $user->id;
        if (! empty($customer->documents)) {
            $customer->documents = Arr::map($customer->documents, function ($document) {
                return getRelativeUrl($document);
            });
        }
        $customer->save();

        return $customer;
    }

    public function destroy(int $id): void
    {
        $customer = Customer::with('user')->findOrFail($id);
        $customer->user?->delete();

        $customer->delete();
    }

    public function getNextCustomerId()
    {
        return (Customer::max('customer_id') ?? 2025000) + 1;
    }
}
