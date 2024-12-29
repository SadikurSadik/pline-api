<?php

namespace App\Http\Controllers;

use App\Enums\VisibilityStatus;
use App\Http\Requests\Auth\LoginRequest;
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
            'access_token' => $accessToken,
            'refresh_token' => $user->refresh_token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
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
            'access_token' => $accessToken,
            'refresh_token' => $request->refresh_token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
            'permissions' => $this->getUserPermissions($user),
        ]);
    }

    public function me(): UserResource
    {
        return new UserResource(auth()->user());
    }

    private function getUserPermissions(User $user)
    {
        $permissions = [
            'locations.index' => true,
            'locations.view' => true,
            'locations.store' => true,
            'locations.update' => true,
            'locations.destroy' => true,
            'countries.index' => true,
            'countries.view' => true,
            'countries.store' => true,
            'countries.update' => true,
            'countries.destroy' => true,
            'states.index' => true,
            'states.view' => true,
            'states.store' => true,
            'states.update' => true,
            'states.destroy' => true,
            'cities.index' => true,
            'cities.view' => true,
            'cities.store' => true,
            'cities.update' => true,
            'cities.destroy' => true,
            'customers.index' => true,
            'customers.view' => true,
            'customers.store' => true,
            'customers.update' => true,
            'customers.destroy' => true,
            'consignees.index' => true,
            'consignees.view' => true,
            'consignees.store' => true,
            'consignees.update' => true,
            'consignees.destroy' => true,
            'vehicles.index' => true,
            'vehicles.view' => true,
            'vehicles.store' => true,
            'vehicles.update' => true,
            'vehicles.destroy' => true,
            'containers.index' => true,
            'containers.view' => true,
            'containers.store' => true,
            'containers.update' => true,
            'containers.destroy' => true,
            'exports.index' => true,
            'exports.view' => true,
            'exports.store' => true,
            'exports.update' => true,
            'exports.destroy' => true,
            'prices.index' => true,
            'invoices.index' => true,
            'invoices.view' => true,
            'invoices.store' => true,
            'invoices.update' => true,
            'invoices.destroy' => true,
            'invoices.paid_invoice' => true,
            'invoices.unpaid_invoice' => true,
            'invoices.partially_paid_invoice' => true,
            'reports.index' => true,
            'ports.index' => true,
            'ports.view' => true,
            'ports.store' => true,
            'ports.update' => true,
            'ports.destroy' => true,
            'towing-rates.index' => true,
            'towing-rates.view' => true,
            'towing-rates.store' => true,
            'towing-rates.update' => true,
            'towing-rates.destroy' => true,
            'shipping-rates.index' => true,
            'shipping-rates.view' => true,
            'shipping-rates.store' => true,
            'shipping-rates.update' => true,
            'shipping-rates.destroy' => true,
            'clearance-rates.index' => true,
            'notifications.index' => true,
            'notifications.view' => true,
            'notifications.store' => true,
            'notifications.update' => true,
            'notifications.destroy' => true,
            'users.index' => true,
            'users.view' => true,
            'users.store' => true,
            'users.update' => true,
            'users.destroy' => true,
            'load-plans.index' => true,
            'load-plans.show' => true,
            'load-plans.store' => true,
            'load-plans.update' => true,
            'load-plans.destroy' => true,
        ];

        return $permissions;
    }
}
