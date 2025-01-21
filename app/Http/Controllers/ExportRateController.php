<?php

namespace App\Http\Controllers;

use App\Exports\ExportRatesExport;
use App\Http\Requests\ExportRate\StoreExportRate;
use App\Http\Requests\ExportRate\UpdateExportRate;
use App\Http\Resources\ExportRate\ExportRateResource;
use App\Services\ExportRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportRateController extends Controller
{
    public function __construct(protected ExportRateService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage export rate', only: ['index']),
            new Middleware('role_or_permission:owner|create export rate', only: ['store']),
            new Middleware('role_or_permission:owner|update export rate', only: ['update']),
            new Middleware('role_or_permission:owner|view export rate', only: ['show']),
            new Middleware('role_or_permission:owner|delete export rate', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel export rate', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return ExportRateResource::collection($data);
    }

    public function store(StoreExportRate $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Export Rate added Successfully.'));
    }

    public function show($id): ExportRateResource
    {
        $data = $this->service->getById($id);

        return new ExportRateResource($data);
    }

    public function update($id, UpdateExportRate $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Export Rate updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Export Rate deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new ExportRatesExport($request->all()), 'vehicle_export_rates.xlsx');
    }
}
