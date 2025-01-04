<?php

namespace App\Http\Controllers;

use App\Http\Requests\Note\StoreAdminNoteRequest;
use App\Http\Resources\Note\AdminNoteResource;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminNoteController extends Controller
{
    public function __construct(protected NoteService $service) {}

    public function storeVccNote(StoreAdminNoteRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $this->service->storeVcc($data, $id);

        return successResponse(__('Note added successfully'));
    }

    public function storeSubmissionVcc(StoreAdminNoteRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $this->service->storeSubmissionVcc($data, $id);

        return successResponse(__('Note added successfully'));
    }

    public function getVccNote($id): AnonymousResourceCollection
    {
        $data = $this->service->getVccNote('VCC_NOTE', $id);

        return AdminNoteResource::collection($data);
    }

    public function getSubmissionNote($id): AnonymousResourceCollection
    {
        $data = $this->service->getVccNote('SUBMISSION_NOTE', $id);

        return AdminNoteResource::collection($data);
    }

    public function storeVehicleNote(StoreAdminNoteRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $this->service->storeVehicleNote($data, $id);

        return successResponse(__('Note added successfully'));
    }

    public function getVehicleNote($id): AnonymousResourceCollection
    {
        $data = $this->service->getVehicleNote($id);

        return AdminNoteResource::collection($data);
    }

    public function storeContainerNote(StoreAdminNoteRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $this->service->storeContainerNote($data, $id);

        return successResponse(__('Note added successfully'));
    }

    public function getContainerNote($id): AnonymousResourceCollection
    {
        $data = $this->service->getContainerNote($id);

        return AdminNoteResource::collection($data);
    }
}
