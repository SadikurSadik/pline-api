<?php

namespace App\Http\Controllers;

use App\Exports\PortsExport;
use App\Http\Requests\Port\StorePortRequest;
use App\Http\Requests\Port\UpdatePortRequest;
use App\Http\Resources\Port\PortResource;
use App\Services\PortService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PortController extends Controller implements HasMiddleware
{
    public function __construct(protected PortService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage port', only: ['index']),
            new Middleware('role_or_permission:owner|create port', only: ['store']),
            new Middleware('role_or_permission:owner|update port', only: ['update']),
            new Middleware('role_or_permission:owner|view port', only: ['show']),
            new Middleware('role_or_permission:owner|delete port', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel port', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return PortResource::collection($data);
    }

    public function store(StorePortRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Port added Successfully.'));
    }

    public function show($id): PortResource
    {
        $data = $this->service->getById($id);

        return new PortResource($data);
    }

    public function update($id, UpdatePortRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Port updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Port deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new PortsExport($request->all()), 'ports.xlsx');
    }
}
