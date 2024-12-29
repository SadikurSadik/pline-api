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
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CityController extends Controller
{
    public function __construct(protected CityService $service) {}

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
