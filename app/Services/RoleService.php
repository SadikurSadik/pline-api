<?php

namespace App\Services;

use App\Filters\FilterByExceptIds;
use App\Filters\FilterByName;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Role::query()->with('permissions');

        return app(FilterPipelineService::class)->apply($query, [
            FilterByName::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Role::find($id);
    }

    public function update(int $id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->fill($data);
        $role->save();

        $role->syncPermissions($data['permissions']);

        if($id == 3) {
            // customer role
            foreach (User::where('role_id', $id)->cursor() as $customer) {
                $customer->syncPermissions($data['permissions']);
            }
        }

        return $role;
    }
}
