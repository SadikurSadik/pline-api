<?php

namespace App\Http\Controllers;

use App\Exports\CountriesExport;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Http\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryResource;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CountryController extends Controller implements HasMiddleware
{
    public function __construct(protected CountryService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage country', only: ['index']),
            new Middleware('role_or_permission:owner|create country', only: ['store']),
            new Middleware('role_or_permission:owner|update country', only: ['update']),
            new Middleware('role_or_permission:owner|view country', only: ['show']),
            new Middleware('role_or_permission:owner|delete country', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel country', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return CountryResource::collection($data);
    }

    public function store(StoreCountryRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Country added Successfully.'));
    }

    public function show($id): CountryResource
    {
        $data = $this->service->getById($id);

        return new CountryResource($data);
    }

    public function update($id, UpdateCountryRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Country updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Country deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new CountriesExport($request->all()), 'countries.xlsx');
    }
}
