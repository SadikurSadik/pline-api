<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Requests\Customer\CustomerQueryMessage;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Jobs\SyncCustomerToAccountingJob;
use App\Models\ContactUs;
use App\Services\CustomerService;
use App\Services\FileManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CustomerController extends Controller implements HasMiddleware
{
    public function __construct(protected CustomerService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage customer', only: ['index']),
            new Middleware('role_or_permission:owner|create customer', only: ['store']),
            new Middleware('role_or_permission:owner|update customer', only: ['update']),
            new Middleware('role_or_permission:owner|view customer', only: ['show']),
            new Middleware('role_or_permission:owner|delete customer', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel customer', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return CustomerResource::collection($data);
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->service->store($request->validated());
        $dispatch = SyncCustomerToAccountingJob::dispatch($customer->id);

        return successResponse(__('Customer added Successfully.'));
    }

    public function show($id): CustomerDetailResource
    {
        $data = $this->service->getById($id);

        return new CustomerDetailResource($data);
    }

    public function update($id, UpdateCustomerRequest $request): JsonResponse
    {
        $customer = $this->service->update($id, $request->validated());
        $dispatch = SyncCustomerToAccountingJob::dispatch($customer->id);

        return successResponse(__('Customer updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Customer deleted Successfully.'));
    }

    public function nextCustomerId(): JsonResponse
    {
        return successResponse('', 200, ['customer_id' => $this->service->getNextCustomerId()]);
    }

    public function uploadDocument(Request $request, FileManagerService $fileStorage): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            $upload = $fileStorage->upload($request->file, 'uploads/customers/documents/');

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

    public function uploadProfilePhoto(Request $request, FileManagerService $fileStorage): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $upload = $fileStorage->uploadPhoto($request->file, 'uploads/customers/photos/', null, 100);

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

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new CustomersExport($request->all()), 'customers.xlsx');
    }

    public function contactMessage(CustomerQueryMessage $request): JsonResponse
    {
        try {
            ContactUs::create($request->validated());

            return response()->json(['success' => true, 'message' => __('Message sent successfully.')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => __('Unable to create contact message.'), 'error' => $e->getMessage()]);
        }
    }
}
