<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserPermissionResource;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return UserResource::collection($data);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('User added Successfully.'));
    }

    public function show($id): UserDetailResource
    {
        $data = $this->service->getById($id);

        return new UserDetailResource($data);
    }

    public function update($id, UpdateUserRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('User updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('User deleted Successfully.'));
    }

    public function permissions($id): UserPermissionResource
    {
        $user = $this->service->getById($id);

        return new UserPermissionResource($user);
    }

    public function updatePermissions($id, Request $request): JsonResponse
    {
        $request->validate([
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => 'required|integer',
        ]);

        $this->service->updatePermissions($id, $request->permissions);

        return successResponse(__('Permissions updated successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new UsersExport($request->all()), 'users.xlsx');
    }
}
