<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return CustomerResource::collection($data);
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Customer added Successfully.'));
    }

    public function show($id): CustomerDetailResource
    {
        $data = $this->service->getById($id);

        return new CustomerDetailResource($data);
    }

    public function update($id, UpdateCustomerRequest $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Customer updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Customer deleted Successfully.'));
    }

    public function nextCustomerId(): JsonResponse
    {
        return successResponse('', ['customer_id' => $this->service->getNextCustomerId()]);
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new CustomersExport($request->all()), 'customers.xlsx');
    }
}
