<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Models\Accounting\Customer;
use App\Models\Accounting\Invoice;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $service) {}

    public function vehicleAccountingInvoice(Request $request): AnonymousResourceCollection
    {
        $userId = null;
        if (auth()->user()?->role_id === Role::CUSTOMER) {
            $userId = Auth::user()->id;
        }
        if (auth()->user()?->role_id === Role::SUB_USER) {
            $userId = Auth::user()->parent_id;
        }
        $invoices = $this->service->all($request->all(), $userId);

        return InvoiceResource::collection($invoices);

    }

    public function serviceAccountingInvoice(Request $request): AnonymousResourceCollection
    {
        $userId = null;
        if (auth()->user()?->role_id === Role::CUSTOMER) {
            $userId = Auth::user()->id;
        }
        if (auth()->user()?->role_id === Role::SUB_USER) {
            $userId = Auth::user()->parent_id;
        }
        $invoices = $this->service->all($request->all(), $userId, 'service');

        return InvoiceResource::collection($invoices);
    }

    public function invoiceSummary(): JsonResponse
    {
        if (! in_array(optional(auth()->user())->role_id, [Role::CUSTOMER, Role::SUPER_ADMIN, Role::OWNER, Role::ADMIN, Role::CUSTOMER])) {
            return response()->json(['success' => false, 'message' => __('You are not authorized to do this action.')], 400);
        }

        $vehicleInvoiceData = $this->service->invoiceSummary([
            'customer_id' => optional(auth()->user())->role_id == Role::CUSTOMER ? auth()->user()->id : '',
            'type' => 'inventory',
        ]);
        $serviceInvoiceData = $this->service->invoiceSummary([
            'customer_id' => optional(auth()->user())->role_id == Role::CUSTOMER ? auth()->user()->id : '',
            'type' => 'service',
        ]);

        return response()->json([
            'vehicle_invoice' => [
                'total_amount' => number_format($vehicleInvoiceData['total_amount'], 2),
                'paid_amount' => number_format($vehicleInvoiceData['total_paid'], 2),
                'balance_due' => number_format($vehicleInvoiceData['total_due'], 2),
                'balance_due_aed' => number_format($vehicleInvoiceData['total_due_aed'], 2),
            ],
            'service_invoice' => [
                'total_amount' => number_format($serviceInvoiceData['total_amount'], 2),
                'paid_amount' => number_format($serviceInvoiceData['total_paid'], 2),
                'balance_due' => number_format($serviceInvoiceData['total_due'], 2),
                'balance_due_aed' => number_format($serviceInvoiceData['total_due_aed'], 2),
            ],
            'advance_report_url' => optional(auth()->user())->role_id == Role::CUSTOMER ? env('ACCOUNTING_APP_URL').'/customer-advance-report/'.Crypt::encrypt(auth()->user()->id) : '',
        ]);
    }

    public function customerInvoicePdf(Request $request)
    {
        $customer_id = auth()->user()->id;

        if ($customer_id) {
            ini_set('max_execution_time', 180);
            ini_set('memory_limit', '3072M');
            $customer = Customer::where(['customer_user_id' => $customer_id])->firstOrFail();

            $query = Invoice::with(['items', 'inventory', 'payments'])
                ->where('customer_id', $customer->customer_id)
                ->where('status', '!=', 0);

            if (! empty($request->invoice_global_search)) {
                if (Str::startsWith($request->invoice_global_search, 'ARO')) {
                    $query->where('invoice_id_str', '=', $request->invoice_global_search);
                } else {
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('inventory', function ($q) use ($request) {
                            $q->where(DB::raw('LOWER(name)'), 'LIKE',
                                '%'.strtolower($request->invoice_global_search).'%');
                        });
                    });
                }
            }

            if (! empty($request->ak_type)) {
                $query->where('ak_type', '=', $request->ak_type);
            }

            if (! empty($request->status)) {
                $query->whereIn('status', explode(',', $request->status));
            }

            $query->orderBy('due_date', 'ASC');

            $invoices = $query->get();

            $totalDue = $invoices->sum(function ($item) {
                return $item->getDue();
            });

            $pdf = PDF::loadView('invoice.customer_invoice_report',
                compact('customer', 'invoices', 'totalDue'))
                ->setPaper('a4', 'portrait')
                ->setOptions(['defaultFont' => 'sans-serif']);

            return $pdf->stream();
        }

        abort(404, 'Customer not found');
    }
}
