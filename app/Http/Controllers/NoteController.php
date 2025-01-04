<?php

namespace App\Http\Controllers;

use App\Enums\NoteStatus;
use App\Enums\Role;
use App\Http\Requests\Note\StoreAdminNoteRequest;
use App\Http\Resources\Note\AdminNoteResource;
use App\Models\Container;
use App\Models\Note;
use App\Models\Vehicle;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function __construct(protected NoteService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $vehicleId = $request->get('vehicle_id');
        $containerId = $request->get('container_id');
        if (! $vehicleId) {
            $column = optional(auth()->user())->role_id == Role::CUSTOMER ? 'cust_view' : 'admin_view';
            Note::where('vehicle_id', $vehicleId)->update([$column => NoteStatus::READ]);
        }
        if (! $containerId) {
            $column = optional(auth()->user())->role_id == Role::CUSTOMER ? 'cust_view' : 'admin_view';
            Note::where('container_id', $containerId)->update([$column => NoteStatus::READ]);
        }

        $data = $this->service->all(['vehicle_id' => $vehicleId, 'container_id' => $containerId]);

        return AdminNoteResource::collection($data);
    }

    public function store(StoreAdminNoteRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $requestData = $request->all();
            $requestData['created_by'] = optional(auth()->user())->id;
            if (optional(auth()->user())->role_id == Role::CUSTOMER) {
                $requestData['cust_view'] = NoteStatus::READ;
            } else {
                $requestData['admin_view'] = NoteStatus::READ;
            }
            $this->service->store($requestData);
            DB::commit();

            if ($vehicleId = $request->get('vehicle_id')) {
                Vehicle::where('id', $vehicleId)->update(['note_status' => NoteStatus::OPEN]);
            }

            if ($exportId = $request->get('export_id')) {
                Container::where('id', $exportId)->update(['note_status' => NoteStatus::OPEN]);
            }

            return successResponse('Note Created successfully!');
        } catch (\Exception $e) {
            DB::rollback();

            return errorResponse('Note creation failed!');
        }
    }

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
