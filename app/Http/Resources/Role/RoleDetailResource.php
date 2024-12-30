<?php

namespace App\Http\Resources\Role;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'modules' => $this->getPermission($this->permissions->pluck('id')->toArray()),
        ];
    }

    private function getPermission(array $permissions)
    {
        $modules = Module::with(['permissions' => function ($q) {
            $q->select('id', 'name', 'module_id');
        }])->select([
            'id',
            'name',
        ])->get();

        return $modules->map(function ($module) use ($permissions) {
            return new ModulePermissionResource($module, $permissions);
        });
    }
}
