<?php

namespace App\Http\Controllers;

use App\Enums\VehicleDocumentType;
use App\Enums\VehiclePhotoType;
use App\Exports\VehiclesExport;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Http\Resources\Vehicle\VehicleDetailResource;
use App\Http\Resources\Vehicle\VehiclePhotosResource;
use App\Http\Resources\Vehicle\VehicleResource;
use App\Services\FileManagerService;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VehicleController extends Controller
{
    public function __construct(protected VehicleService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return VehicleResource::collection($data);
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Vehicle added Successfully.'));
    }

    public function show(string $id): VehicleDetailResource
    {
        $data = $this->service->getById($id);

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
            'photo' => 'required|image',
        ]);

        try {
            // $upload = app(FileManagerService::class)->uploadPhoto(file_get_contents($request->file), 'uploads/brands/', null, 100);
            $upload = $request->photo->store('uploads/vehicles/photos/'.$request->get('vehicle_id', 'tmp'));

            if (! $upload) {
                return response()->json(['success' => false, 'url' => null, 'message' => 'Failed to file upload'], 400);
            }

            return response()->json(['success' => true, 'url' => Storage::url($upload)]);
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
            'document' => 'required',
        ]);

        try {
            // $upload = app(FileManagerService::class)->uploadPhoto(file_get_contents($request->file), 'uploads/brands/', null, 100);
            $upload = $request->document->store('uploads/vehicles/documents/'.$request->get('vehicle_id', 'tmp'));

            if (! $upload) {
                return response()->json(['success' => false, 'url' => null, 'message' => 'Failed to file upload'], 400);
            }

            return response()->json(['success' => true, 'url' => Storage::url($upload)]);
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
        $zipPath = storage_path("app/public/uploads/vehicles/photos/tmp/{$zipFileName}");

        return $fileManagerService->downloadAsZip($zipPath, $photos);
    }

    public function downloadVehicleDocuments($id, Request $request, FileManagerService $fileManagerService): BinaryFileResponse|JsonResponse
    {
        $type = $request->get('type', VehicleDocumentType::DOCUMENT->value);
        $documents = $this->service->getVehicleDocuments($id, $type)->pluck('name');
        $zipFileName = 'vehicle_documents_'.date('Y-m-d').'.zip';
        $zipPath = storage_path("app/public/uploads/vehicles/documents/tmp/{$zipFileName}");

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

            return redirect()->back()->with('success', 'Photos added successfully.');
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
}