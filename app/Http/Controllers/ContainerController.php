<?php

namespace App\Http\Controllers;

use App\Enums\ContainerPhotoType;
use App\Exports\ContainersExport;
use App\Http\Requests\Container\StoreContainerRequest;
use App\Http\Requests\Container\UpdateContainerRequest;
use App\Http\Resources\Container\ContainerDetailResource;
use App\Http\Resources\Container\ContainerPhotosResource;
use App\Http\Resources\Container\ContainerResource;
use App\Services\ContainerService;
use App\Services\FileManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContainerController extends Controller
{
    public function __construct(protected ContainerService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return ContainerResource::collection($data);
    }

    public function store(StoreContainerRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Container added Successfully.'));
    }

    public function show($id): ContainerDetailResource
    {
        $data = $this->service->getById($id);

        return new ContainerDetailResource($data);
    }

    public function update(UpdateContainerRequest $request, $id): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Container updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->destroy($id);

            return successResponse(__('Container Deleted Successfully.'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return errorResponse(__('Container Deleted failed!'));
        }
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new ContainersExport($request->all()), 'containers.xlsx');
    }

    public function uploadPhoto(Request $request, FileManagerService $fileStorage): JsonResponse
    {
        $request->validate([
            'photo' => 'required|image',
        ]);

        try {
            $upload = $fileStorage->upload($request->photo, 'uploads/containers/photos/tmp');

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

    public function uploadDocument(Request $request, FileManagerService $fileStorage): JsonResponse
    {
        $request->validate([
            'file' => 'required',
        ]);

        try {
            $upload = $fileStorage->upload($request->file, 'uploads/containers/documents/tmp');

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

    public function downloadDocuments($id, FileManagerService $fileManagerService): BinaryFileResponse|JsonResponse
    {
        $documents = $this->service->getDocuments($id)->pluck('name');
        $zipFileName = 'container_documents_'.date('Y-m-d').'.zip';
        $zipPath = storage_path("app/public/uploads/containers/documents/tmp/{$zipFileName}");

        return $fileManagerService->downloadAsZip($zipPath, $documents);
    }

    public function addMorePhotos($id, Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'type' => 'required|integer',
            'photos' => 'required|array|min:1',
        ]);

        try {
            $this->service->savePhotos($request->photos, $id, $request->type);

            return redirect()->back()->with('success', 'Photos added successfully.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Photos upload failed!',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function downloadPhotos(
        $id,
        Request $request,
        FileManagerService $fileManagerService
    ): BinaryFileResponse|JsonResponse {
        $type = $request->get('type', ContainerPhotoType::CONTAINER_PHOTO->value);
        $photos = $this->service->getPhotos($id, $type)->pluck('name');
        $zipFileName = 'container_photos_'.date('Y-m-d').'.zip';
        $zipPath = storage_path("app/public/uploads/containers/photos/tmp/{$zipFileName}");

        return $fileManagerService->downloadAsZip($zipPath, $photos);
    }

    public function allPhotos($id): ContainerPhotosResource
    {
        $data = $this->service->getById($id);

        return new ContainerPhotosResource($data);
    }
}
