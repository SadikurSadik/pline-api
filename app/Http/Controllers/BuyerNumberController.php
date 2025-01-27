<?php

namespace App\Http\Controllers;

use App\Enums\VisibilityStatus;
use App\Exports\BuyerNumbersExport;
use App\Http\Requests\BuyerNumber\AssignCustomerRequest;
use App\Http\Requests\BuyerNumber\StoreBuyerNumberRequest;
use App\Http\Requests\BuyerNumber\UpdateBuyerNumberRequest;
use App\Http\Resources\BuyerNumber\BuyerNumberDetailResource;
use App\Http\Resources\BuyerNumber\BuyerNumberResource;
use App\Services\BuyerNumberService;
use App\Services\FileManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    public function store(StoreBuyerNumberRequest $request): JsonResponse
    {
        try {
            $this->service->store($request->all());

            return successResponse(__('Buyer Number added Successfully.'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }

    public function update(UpdateBuyerNumberRequest $request, $id): JsonResponse
    {
        try {
            $this->service->update($request->all(), $id);

            return successResponse(__('Buyer Number update Successfully.'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Buyer Number deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new BuyerNumbersExport($request->all()), 'buyer_numbers.xlsx');
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

    public function submitAddCustomer(AssignCustomerRequest $request): JsonResponse
    {
        try {
            $this->service->addCustomer($request->all());

            return successResponse(__('Buyer Number added successfully.'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }

    public function submitReplaceCustomer(AssignCustomerRequest $request): JsonResponse
    {
        try {
            $this->service->replaceCustomer($request->all());

            return successResponse(__('Buyer Number update successfully.'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }

    public function customerBuyerNumber(Request $request)
    {
        $filters = $request->all();
        $filters['status'] = VisibilityStatus::ACTIVE;
        $filters['customer_user_ids'] = [auth()->user()->id];

        $data = $this->service->all($filters);

        return BuyerNumberResource::collection($data);
    }

    public function sheetWiseBuyerNumber(Request $request, $id): AnonymousResourceCollection
    {
        $filters = $request->all();
        $filters['sheet_id'] = $id;

        $data = $this->service->all($filters);

        return BuyerNumberResource::collection($data);
    }
}
