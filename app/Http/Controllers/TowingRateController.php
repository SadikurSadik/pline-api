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
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TowingRateController extends Controller
{
    public function __construct(protected TowingRateService $service) {}

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
