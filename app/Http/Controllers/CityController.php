<?php

namespace App\Http\Controllers;

use App\Exports\CitiesExport;
use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\Http\Resources\City\CityResource;
use App\Services\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CityController extends Controller implements HasMiddleware
{
    public function __construct(protected CityService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage city', only: ['index']),
            new Middleware('role_or_permission:owner|create city', only: ['store']),
            new Middleware('role_or_permission:owner|update city', only: ['update']),
            new Middleware('role_or_permission:owner|view city', only: ['show']),
            new Middleware('role_or_permission:owner|delete city', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel city', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return CityResource::collection($data);
    }

    public function store(StoreCityRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('City added Successfully.'));
    }

    public function show($id): CityResource
    {
        $data = $this->service->getById($id);

        return new CityResource($data);
    }

    public function update($id, UpdateCityRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('City updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('City deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new CitiesExport($request->all()), 'cities.xlsx');
    }
}
