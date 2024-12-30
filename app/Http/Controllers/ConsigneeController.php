<?php

namespace App\Http\Controllers;

use App\Exports\ConsigneesExport;
use App\Http\Requests\Consignee\StoreConsigneeRequest;
use App\Http\Requests\Consignee\UpdateConsigneeRequest;
use App\Http\Resources\Consignee\ConsigneeDetailResource;
use App\Http\Resources\Consignee\ConsigneeResource;
use App\Services\ConsigneeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConsigneeController extends Controller
{
    public function __construct(protected ConsigneeService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return ConsigneeResource::collection($data);
    }

    public function store(StoreConsigneeRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Consignee added Successfully.'));
    }

    public function show($id): ConsigneeDetailResource
    {
        $data = $this->service->getById($id);

        return new ConsigneeDetailResource($data);
    }

    public function update($id, UpdateConsigneeRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Consignee updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Consignee deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new ConsigneesExport($request->all()), 'consignees.xlsx');
    }
}
