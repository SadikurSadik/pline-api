<?php

namespace App\Http\Controllers;

use App\Exports\LocationsExport;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LocationController extends Controller implements HasMiddleware
{
    public function __construct(protected LocationService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage location', only: ['index']),
            new Middleware('role_or_permission:owner|create location', only: ['store']),
            new Middleware('role_or_permission:owner|update location', only: ['update']),
            new Middleware('role_or_permission:owner|view location', only: ['show']),
            new Middleware('role_or_permission:owner|delete location', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel location', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return LocationResource::collection($data);
    }

    public function store(StoreLocationRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Yard added Successfully.'));
    }

    public function show($id): LocationResource
    {
        $data = $this->service->getById($id);

        return new LocationResource($data);
    }

    public function update($id, UpdateLocationRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Yard updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Yard deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new LocationsExport($request->all()), 'yards.xlsx');
    }
}
