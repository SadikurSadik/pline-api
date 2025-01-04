<?php

namespace App\Http\Controllers;

use App\Http\Requests\Note\StoreAdminNoteRequest;
use App\Http\Resources\Note\AdminNoteResource;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NoteController extends Controller
{
    public function __construct(protected NoteService $service) {}

    public function containerStoreNote(StoreAdminNoteRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $this->service->containerStoreNote($data, $id);

        return successResponse(__('Note added successfully'));
    }

    public function containerGetNote($id): AnonymousResourceCollection
    {
        $data = $this->service->containerGetNote($id);

        return AdminNoteResource::collection($data);
    }

    public function vehicleStoreNote(StoreAdminNoteRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $this->service->vehicleStoreNote($data, $id);

        return successResponse(__('Note added successfully'));
    }

    public function vehicleGetNote($id): AnonymousResourceCollection
    {
        $data = $this->service->vehicleGetNote($id);

        return AdminNoteResource::collection($data);
    }
}
