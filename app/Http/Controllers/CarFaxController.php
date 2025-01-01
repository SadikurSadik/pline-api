<?php

namespace App\Http\Controllers;

use App\Exports\CarFaxesExport;
use App\Http\Requests\CarFax\CustomerCarFaxRequest;
use App\Http\Requests\CarFax\StoreCarFaxRequest;
use App\Http\Requests\CarFax\UpdateCarFaxRequest;
use App\Http\Resources\CarFax\CarFaxResource;
use App\Services\CarFaxService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CarFaxController extends Controller
{
    public function __construct(protected CarFaxService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return CarFaxResource::collection($data);
    }

    public function store(StoreCarFaxRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Carfax added successfully.'));
    }

    public function carFaxRequest(CustomerCarFaxRequest $request): JsonResponse
    {
        $this->service->store(
            array_merge($request->validated(), [
                'requested_by' => auth()->id(),
            ])
        );

        return successResponse(__('Carfax requested successfully.'));
    }

    public function show($id): CarFaxResource
    {
        $data = $this->service->getById($id);

        return new CarFaxResource($data);
    }

    public function update(UpdateCarFaxRequest $request, string $id): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Carfax updated successfully.'));
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Carfax deleted successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new CarFaxesExport($request->all()), 'car_faxes.xlsx');
    }
}
