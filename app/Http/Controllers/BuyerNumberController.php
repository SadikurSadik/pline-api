<?php

namespace App\Http\Controllers;

use App\Http\Resources\BuyerNumber\BuyerNumberDetailResource;
use App\Http\Resources\BuyerNumber\BuyerNumberResource;
use App\Services\BuyerNumberService;
use App\Services\FileManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BuyerNumberController extends Controller
{
    public function __construct(protected BuyerNumberService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return BuyerNumberResource::collection($data);
    }

    public function show($id): BuyerNumberDetailResource
    {
        $data = $this->service->getById($id);

        return new BuyerNumberDetailResource($data);
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Buyer Number deleted Successfully.'));
    }

    public function BuyerNumberAttachment(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required',
        ]);

        try {
            $upload = app(FileManagerService::class)->upload($request->file, 'uploads/buyer-number/attachment');

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
}
