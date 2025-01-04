<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClearanceRate\StoreClearanceRateRequest;
use App\Http\Resources\ClearanceRate\ClearanceRateDetailResource;
use App\Services\ClearanceRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ClearanceRateController extends Controller implements HasMiddleware
{
    public function __construct(protected ClearanceRateService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage clearance rate', only: ['index']),
            new Middleware('role_or_permission:owner|update clearance rate', only: ['store']),
        ];
    }

    public function index(): ClearanceRateDetailResource
    {
        $data = $this->service->all();

        return new ClearanceRateDetailResource($data);
    }

    public function store(StoreClearanceRateRequest $request): JsonResponse
    {
        $this->service->update('clearance_rate', $request->clearance_rate);
        $this->service->update('profit', $request->profit);

        return successResponse(__('Clearance Rate updated successfully.'));
    }
}
