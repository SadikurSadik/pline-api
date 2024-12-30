<?php

namespace App\Services;

use App\Filters\FilterByExceptIds;
use App\Filters\FilterByName;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Role::query()->with('permissions');

        return app(FilterPipelineService::class)->apply($query, [
            FilterByExceptIds::class,
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

        return $role;
    }
}
