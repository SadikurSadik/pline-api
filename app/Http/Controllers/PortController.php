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
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PortController extends Controller
{
    public function __construct(protected PortService $service) {}

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
