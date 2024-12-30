<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClearanceRate\StoreClearanceRateRequest;
use App\Http\Resources\ClearanceRate\ClearanceRateDetailResource;
use App\Services\ClearanceRateService;
use Illuminate\Http\JsonResponse;

class ClearanceRateController extends Controller
{
    public function __construct(protected ClearanceRateService $service) {}

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
