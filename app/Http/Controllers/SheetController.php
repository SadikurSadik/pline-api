<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sheet\StoreSheetRequest;
use App\Http\Requests\Sheet\UpdateSheetRequest;
use App\Http\Resources\Sheet\SheetDetailResource;
use App\Http\Resources\Sheet\SheetResource;
use App\Service\SheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SheetController extends Controller
{
    public function __construct(protected SheetService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return SheetResource::collection($data);
    }

    public function store(StoreSheetRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Sheet added Successfully.'));
    }

    public function show($id): SheetDetailResource
    {
        $data = $this->service->getById($id);

        return new SheetDetailResource($data);
    }

    public function update(UpdateSheetRequest $request, $id): JsonResponse
    {
        $this->service->update($request->validated(), $id);

        return successResponse(__('Sheet updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Sheet deleted Successfully.'));
    }
}
