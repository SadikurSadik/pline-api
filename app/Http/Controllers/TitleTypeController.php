<?php

namespace App\Http\Controllers;

use App\Exports\TitleTypesExport;
use App\Http\Requests\TitleType\StoreTitleTypeRequest;
use App\Http\Requests\TitleType\UpdateTitleTypeRequest;
use App\Http\Resources\TitleType\TitleTypeResource;
use App\Services\TitleTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TitleTypeController extends Controller implements HasMiddleware
{
    public function __construct(protected TitleTypeService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage title type', only: ['index']),
            new Middleware('role_or_permission:owner|create title type', only: ['store']),
            new Middleware('role_or_permission:owner|update title type', only: ['update']),
            new Middleware('role_or_permission:owner|view title type', only: ['show']),
            new Middleware('role_or_permission:owner|delete title type', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel title type', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return TitleTypeResource::collection($data);
    }

    public function store(StoreTitleTypeRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Title Type added Successfully.'));
    }

    public function show($id): TitleTypeResource
    {
        $data = $this->service->getById($id);

        return new TitleTypeResource($data);
    }

    public function update($id, UpdateTitleTypeRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Title Type updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Title Type deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new TitleTypesExport($request->all()), 'vehicle_title_types.xlsx');
    }
}
