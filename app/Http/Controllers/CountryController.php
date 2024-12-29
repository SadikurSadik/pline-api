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
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CountryController extends Controller
{
    public function __construct(protected CountryService $service) {}

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
