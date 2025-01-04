<?php

namespace App\Http\Controllers;

use App\Exports\TowingRatesExport;
use App\Http\Requests\TowingRate\StoreTowingRateRequest;
use App\Http\Requests\TowingRate\UpdateTowingRateRequest;
use App\Http\Resources\TowingRate\TowingRateDetailResource;
use App\Http\Resources\TowingRate\TowingRateResource;
use App\Services\TowingRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TowingRateController extends Controller implements HasMiddleware
{
    public function __construct(protected TowingRateService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage towing rate', only: ['index']),
            new Middleware('role_or_permission:owner|create towing rate', only: ['store']),
            new Middleware('role_or_permission:owner|update towing rate', only: ['update']),
            new Middleware('role_or_permission:owner|view towing rate', only: ['show']),
            new Middleware('role_or_permission:owner|delete towing rate', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel towing rate', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return TowingRateResource::collection($data);
    }

    public function store(StoreTowingRateRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Towing Rate added Successfully.'));
    }

    public function show($id): TowingRateDetailResource
    {
        $data = $this->service->getById($id);

        return new TowingRateDetailResource($data);
    }

    public function update(UpdateTowingRateRequest $request, $id): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Towing Rate Update Successfully.'));
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Towing Rate deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new TowingRatesExport($request->all()), 'towing_rates.xlsx');
    }
}
