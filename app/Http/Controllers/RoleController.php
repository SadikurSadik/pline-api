<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleDetailResource;
use App\Http\Resources\Role\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public function __construct(protected RoleService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage role', only: ['index', 'show']),
            new Middleware('role_or_permission:owner|update role', only: ['update']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all([
            'order_by' => 'ASC',
            'except_ids' => [Role::CUSTOMER->value, Role::SUB_USER->value],
        ]);

        return RoleResource::collection($data);
    }

    public function show($id): RoleDetailResource
    {
        $data = $this->service->getById($id);

        return new RoleDetailResource($data);
    }

    public function update($id, UpdateRoleRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Role updated Successfully.'));
    }
}
