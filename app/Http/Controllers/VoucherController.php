<?php

namespace App\Http\Controllers;

use App\Http\Resources\Voucher\AdvancedVoucherResource;
use App\Http\Resources\Voucher\InvoiceVoucherResource;
use App\Models\Accounting\Customer;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VoucherController extends Controller
{
    public function __construct(protected VoucherService $service){}

    public function advancedVoucher(Request $request): AnonymousResourceCollection
    {
        $customer = Customer::where('customer_user_id', auth()->user()->id)->firstOrFail();
        $data = $this->service->customerAdvanceVoucherList(array_merge($request->all(), ['customer_id' => $customer->customer_id]));

        return AdvancedVoucherResource::collection($data);
    }

    public function invoiceVoucher(Request $request): AnonymousResourceCollection
    {
        $customer = Customer::where('customer_user_id', auth()->user()->id)->firstOrFail();
        $data = $this->service->customerInvoiceVoucherList(array_merge($request->all(), ['customer_id' => $customer->customer_id]));

        return InvoiceVoucherResource::collection($data);
    }
}
