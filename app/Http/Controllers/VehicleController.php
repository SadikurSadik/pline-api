<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Enums\VehicleDocumentType;
use App\Enums\VehiclePhotoType;
use App\Exports\VehiclesExport;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\Vehicle\VehicleDetailResource;
use App\Http\Resources\Vehicle\VehiclePhotosResource;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Models\Vehicle;
use App\Services\FileManagerService;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VehicleController extends Controller implements HasMiddleware
{
    public function __construct(protected VehicleService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage vehicle', only: ['index']),
            new Middleware('role_or_permission:owner|create vehicle', only: ['store']),
            new Middleware('role_or_permission:owner|update vehicle', only: ['update']),
            new Middleware('role_or_permission:owner|view vehicle', only: ['show']),
            new Middleware('role_or_permission:owner|delete vehicle', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel vehicle', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->all();
        if (optional(auth()->user())->role_id == Role::CUSTOMER) {
            $filters['customer_user_id'] = auth()->user()->id;
        } elseif (optional(auth()->user())->role_id == Role::SUB_USER) {
            $filters['customer_user_id'] = auth()->user()->parent_id;
        }
        $data = $this->service->all($filters);

        return VehicleResource::collection($data);
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Vehicle added Successfully.'));
    }

    public function show(string $id): VehicleDetailResource
    {
        $customerUserId = null;
        if (optional(auth()->user())->role_id == Role::CUSTOMER) {
            $customerUserId = auth()->user()->id;
        } elseif (optional(auth()->user())->role_id == Role::SUB_USER) {
            $customerUserId = auth()->user()->parent_id;
        }
        $data = $this->service->getById($id, $customerUserId);

        return new VehicleDetailResource($data);
    }

    public function getByVin(Request $request): VehicleDetailResource
    {
        $customerUserId = null;
        if (optional(auth()->user())->role_id == Role::CUSTOMER) {
            $customerUserId = auth()->user()->id;
        } elseif (optional(auth()->user())->role_id == Role::SUB_USER) {
            $customerUserId = auth()->user()->parent_id;
        }
        $data = $this->service->getByVin($request->vin, $customerUserId);

        return new VehicleDetailResource($data);
    }

    public function update(UpdateVehicleRequest $request, string $id): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Vehicle updated Successfully.'));
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Vehicle Deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new VehiclesExport($request->all()), 'vehicles.xlsx');
    }

    public function uploadPhoto(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        try {
            $upload = app(FileManagerService::class)->uploadPhotoWithThumbnail(file_get_contents($request->file), 'uploads/vehicle/photos');

            if (! $upload) {
                return response()->json(['success' => false, 'url' => null, 'message' => 'Failed to file upload'], 400);
            }

            return response()->json(['success' => true, 'url' => $upload]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile file.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function uploadDocument(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required',
        ]);

        try {
            $upload = app(FileManagerService::class)->upload($request->file, 'uploads/vehicle/documents');

            if (! $upload) {
                return response()->json(['success' => false, 'url' => null, 'message' => 'Failed to file upload'], 400);
            }

            return response()->json(['success' => true, 'url' => $upload]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile file.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function downloadVehiclePhotos($id, Request $request, FileManagerService $fileManagerService): BinaryFileResponse|JsonResponse
    {
        $type = $request->get('type', VehiclePhotoType::YARD_PHOTO->value);
        $photos = $this->service->getVehiclePhotos($id, $type)->pluck('name');
        $zipFileName = 'vehicle_photos_'.date('Y-m-d').'.zip';
        $zipPath = storage_path("app/public/uploads/vehicles/photos/{$zipFileName}");

        return $fileManagerService->downloadAsZip($zipPath, $photos);
    }

    public function downloadVehicleDocuments($id, Request $request, FileManagerService $fileManagerService): BinaryFileResponse|JsonResponse
    {
        $type = $request->get('type', VehicleDocumentType::DOCUMENT->value);
        $documents = $this->service->getVehicleDocuments($id, $type)->pluck('name');
        $zipFileName = 'vehicle_documents_'.date('Y-m-d').'.zip';
        $zipPath = storage_path("app/public/uploads/vehicles/documents/{$zipFileName}");

        return $fileManagerService->downloadAsZip($zipPath, $documents);
    }

    public function addMorePhotos($id, Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'type' => 'required|integer',
            'photos' => 'required|array|min:1',
        ]);

        try {
            $this->service->saveVehiclePhoto($request->photos, $id, $request->type);

            return successResponse('Photos added successfully.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Photos upload failed!',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function allPhotos($id): VehiclePhotosResource
    {
        $data = $this->service->getById($id);

        return new VehiclePhotosResource($data);
    }

    public function changeNoteStatus($id, Request $request): JsonResponse
    {
        Vehicle::find($id)->update(['note_status' => $request->get('note_status')]);

        return response()->json(['message' => $request->get('note_status') == '1' ? 'Note Closed successfully.' : 'Note opened successfully.']);
    }
}
