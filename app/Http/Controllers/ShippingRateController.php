<?php

namespace App\Http\Controllers;

use App\Exports\ShippingRatesExport;
use App\Http\Requests\ShippingRate\StoreShippingRateRequest;
use App\Http\Requests\ShippingRate\UpdateShippingRateRequest;
use App\Http\Resources\ShippingRate\ShippingRateDetailResource;
use App\Http\Resources\ShippingRate\ShippingRateResource;
use App\Services\ShippingRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ShippingRateController extends Controller implements HasMiddleware
{
    public function __construct(protected ShippingRateService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage shipping rate', only: ['index']),
            new Middleware('role_or_permission:owner|create shipping rate', only: ['store']),
            new Middleware('role_or_permission:owner|update shipping rate', only: ['update']),
            new Middleware('role_or_permission:owner|view shipping rate', only: ['show']),
            new Middleware('role_or_permission:owner|delete shipping rate', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel shipping rate', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return ShippingRateResource::collection($data);
    }

    public function store(StoreShippingRateRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Shipping Rate added Successfully.'));
    }

    public function show($id): ShippingRateDetailResource
    {
        $data = $this->service->getById($id);

        return new ShippingRateDetailResource($data);
    }

    public function update(UpdateShippingRateRequest $request, $id): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Shipping Rate Update Successfully.'));
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Shipping Rate deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new ShippingRatesExport($request->all()), 'shipping_rates.xlsx');
    }
}
