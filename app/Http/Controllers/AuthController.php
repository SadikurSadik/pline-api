<?php

namespace App\Http\Controllers;

use App\Enums\VisibilityStatus;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where(DB::raw('BINARY `username`'), $request->username)
            ->where('status', VisibilityStatus::ACTIVE->value)
            ->first();
        if (empty($user)) {
            return response()->json([
                'status' => 400,
                'error' => __('Credential mismatched.'),
            ], 401);
        }

        $accessToken = $user->createToken('auth_token')->plainTextToken;
        if (empty($user->refresh_token) || Carbon::parse($user->refresh_token_expire_at)->lessThan(now())) {
            $refreshToken = Str::random(80);
            $user->refresh_token = $refreshToken;
            $user->refresh_token_expire_at = Carbon::now()->addDays(30);
            $user->save();
        }

        return response()->json([
            'status' => 200,
            'access_token' => $accessToken,
            'refresh_token' => $user->refresh_token,
            'token_type' => 'Bearer',
            'user' => new UserDetailResource($user),
            'permissions' => $this->getUserPermissions($user),
        ]);
    }

    public function refresh(Request $request): JsonResponse
    {
        $request->validate([
            'refresh_token' => 'required',
        ]);

        $user = User::where('refresh_token', $request->refresh_token)
            ->where('refresh_token_expire_at', '>', Carbon::now())
            ->first();

        if (! $user) {
            return errorResponse(__('Invalid or expired refresh token'), 401);
        }

        // Revoke old access token and generate new ones
        $user->tokens()->delete();
        $accessToken = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'access_token' => $accessToken,
            'refresh_token' => $request->refresh_token,
            'token_type' => 'Bearer',
            'user' => new UserDetailResource($user),
            'permissions' => $this->getUserPermissions($user),
        ]);
    }

    public function me(): UserResource
    {
        return new UserResource(auth()->user());
    }

    private function getUserPermissions(User $user): array|\stdClass
    {
        $permissions = $user->getAllPermissions()->pluck('id', 'name')->toArray();

        return empty($permissions) ? new \stdClass : $permissions;
    }
}
