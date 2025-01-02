<?php

namespace App\Http\Controllers;

use App\Http\Resources\Vcc\VccDetailResource;
use App\Http\Resources\Vcc\VccResource;
use App\Services\VccService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class VccController extends Controller
{
    public function __construct(protected VccService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return VccResource::collection($data);
    }

    public function show($id)
    {
        $data = $this->service->getById($id);

        return new VccDetailResource($data);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->destroy($id);

            return successResponse(__('VCC Deleted Successfully'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }
}
