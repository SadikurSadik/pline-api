<?php

namespace App\Services;

use App\Enums\Role;
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
        $query = Customer::with(['user']);

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
        return Customer::with(['user', 'country', 'state', 'city'])->find($id);
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
        $customer = Customer::findOrNew($id);
        $user = User::findOrNew($customer->user_id);
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user->fill($data);
        $user->role_id = Role::CUSTOMER->value;
        $user->save();
        $user->syncRolePermissions();

        $customer->fill($data);
        $customer->user_id = $user->id;
        $customer->save();

        return $customer;
    }

    public function destroy(int $id): void
    {
        $customer = Customer::with('user')->findOrFail($id);
        $customer->user?->delete();

        $customer->delete();
    }
}
