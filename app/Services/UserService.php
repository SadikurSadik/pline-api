<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByEmail;
use App\Filters\FilterByName;
use App\Filters\FilterByRole;
use App\Filters\FilterByStatus;
use App\Filters\FilterByUsername;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class UserService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = User::query();

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByName::class,
            FilterByUsername::class,
            FilterByEmail::class,
            FilterByRole::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return User::find($id);
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
        $user = User::findOrNew($id);
        $user->fill($data);
        $user->save();
        if ($id === null) {
            $user->syncRolePermissions();
        }

        return $user;
    }

    public function destroy(int $id): void
    {
        $user = User::findOrFail($id);

        $user->delete();
    }

    public function updatePermissions($id, $permissions): void
    {
        $user = $this->getById($id);
        $user->syncPermissions($permissions);
    }
}
