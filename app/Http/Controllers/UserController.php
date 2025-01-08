<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Enums\VisibilityStatus;
use App\Exports\UsersExport;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserPermissionResource;
use App\Http\Resources\User\UserResource;
use App\Models\Customer;
use App\Services\FileManagerService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}

    /*public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner,customer|manage user', only: ['index', 'permissions', 'updatePermissions', 'changeStatus']),
            new Middleware('role_or_permission:owner|create user', only: ['store']),
            new Middleware('role_or_permission:owner|update user', only: ['update']),
            new Middleware('role_or_permission:owner|view user', only: ['show']),
            new Middleware('role_or_permission:owner|delete user', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel user', only: ['exportExcel']),
        ];
    }*/

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->all();
        if (auth()->user()->role_id == Role::CUSTOMER) {
            $filters['role_id'] = Role::SUB_USER->value;
            $filters['parent_id'] = auth()->user()->id;
        }
        $data = $this->service->all($filters);

        return UserResource::collection($data);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (auth()->user()->role_id == Role::CUSTOMER) {
            $data['parent_id'] = auth()->user()->id;
        }
        $this->service->store($data);

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

    public function changeStatus($id): JsonResponse
    {
        try {
            $user = $this->service->getById($id);
            $this->service->update($id, ['status' => ! ($user->status == VisibilityStatus::ACTIVE)]);

            return successResponse(__('Customer status changed successfully.!'));
        } catch (\Exception $e) {
            return errorResponse();
        }
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new UsersExport($request->all()), 'users.xlsx');
    }

    public function uploadProfilePhoto(FileManagerService $fileStorage, Request $request): JsonResponse
    {
        $request->validate( [
            'photo' => 'required|image',
        ] );

        try {
            $upload = $fileStorage->uploadPhoto( $request->photo, 'uploads/users/profile-pics', null, 200 );

            if ( !$upload ) {
                return response()->json( [ 'success' => false, 'profile_photo' => '', 'message' => 'Failed to file upload' ], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST );
            }

            $this->service->update( auth()->user()->id, [ 'photo_url' => str_replace( config('app.media_url'), '', $upload ) ] );

            return response()->json( [ 'success' => true, 'profile_photo' => $upload ] );
        } catch ( \Exception $e ) {
            return response()->json( [
                'success' => false,
                'message' => 'Failed to changed password.' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST );
        }
    }
}
