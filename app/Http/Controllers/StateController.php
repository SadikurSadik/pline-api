<?php

namespace App\Http\Controllers;

use App\Exports\StatesExport;
use App\Http\Requests\State\StoreStateRequest;
use App\Http\Requests\State\UpdateStateRequest;
use App\Http\Resources\State\StateResource;
use App\Services\StateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StateController extends Controller
{
    public function __construct(protected StateService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return StateResource::collection($data);
    }

    public function store(StoreStateRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('State added Successfully.'));
    }

    public function show($id): StateResource
    {
        $data = $this->service->getById($id);

        return new StateResource($data);
    }

    public function update($id, UpdateStateRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('State updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('State deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new StatesExport($request->all()), 'states.xlsx');
    }
}
