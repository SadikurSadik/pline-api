<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Resources\Voucher\AdvancedVoucherResource;
use App\Http\Resources\Voucher\CashflowVoucherResource;
use App\Http\Resources\Voucher\InvoiceVoucherResource;
use App\Models\Accounting\AdvancedAccount;
use App\Models\Accounting\CashflowTransaction;
use App\Models\Accounting\Customer;
use App\Models\Accounting\InvoicePayment;
use App\Services\VoucherService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class VoucherController extends Controller
{
    public function __construct(protected VoucherService $service){}

    public function index(Request $request)
    {
        $limit = $request->get('limit', 50);

        if (auth()->user()->role_id != Role::OWNER) {
            return response()->json([
                'success' => false,
                'message' => __('You are not authorized to do this action.'),
            ], 400);
        }

        if ($request->type == 'ttcash') {
            $ttCashPayments = CashflowTransaction::with('payment_method')
                ->where(['account' => 3, 'type' => 2, 'owner_approval_status' => 0]);
            if ($request->get('global_search')) {
                $ttCashPayments = $ttCashPayments->where(function ($q) use ($request) {
                    $q->where('voucher_number', $request->global_search)
                        ->orWhere('name', 'LIKE', '%'.$request->global_search.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->global_search.'%');
                });
            }

            if ($request->get('payment_mode')) {
                $ttCashPayments = $ttCashPayments->where('payment_mode', '=', $request->get('payment_mode'));
            }

            return CashflowVoucherResource::collection($ttCashPayments->paginate($limit));
        }
        if ($request->type == 'othercash') {
            $otherPayments = CashflowTransaction::with('payment_method')
                ->where(['account' => 2, 'type' => 2, 'owner_approval_status' => 0]);
            if ($request->get('global_search')) {
                $otherPayments = $otherPayments->where(function ($q) use ($request) {
                    $q->where('voucher_number', $request->global_search)
                        ->orWhere('name', 'LIKE', '%'.$request->global_search.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->global_search.'%');
                });
            }

            if ($request->get('payment_mode')) {
                $otherPayments = $otherPayments->where('payment_mode', '=', $request->get('payment_mode'));
            }

            return CashflowVoucherResource::collection($otherPayments->paginate($limit));
        } else {
            $customerAdvances = AdvancedAccount::with('payment_method')->where('amount', '<',
                0)->where('owner_approval_status', 0)
                ->withoutNonCash()
                ->orderby('date', 'asc');
            if ($request->get('global_search')) {
                $customerAdvances = $customerAdvances->where(function ($q) use ($request) {
                    $q->where('voucher_no', $request->global_search)
                        ->orWhere('note', 'LIKE', '%'.$request->global_search.'%');
                });
            }

            if ($request->get('payment_mode')) {
                $customerAdvances = $customerAdvances->where('payment_mode', '=', $request->get('payment_mode'));
            }

            return AdvancedVoucherResource::collection($customerAdvances->paginate($limit));
        }
    }

    public function rejectApproveVoucher($id, Request $request): JsonResponse
    {
        $rules = ['approve_reject' => 'required', 'type' => 'required'];
        if ($request->approve_reject == 'rejected') {
            $rules['app_reject_note'] = 'required';
        }
        $this->validate($request, $rules);

        if (auth()->user()->role_id != Role::OWNER) {
            return response()->json([
                'success' => false,
                'message' => __('You are not authorized to do this action.'),
            ], 400);
        }

        try {
            if ($request->type === 'advanced') {
                $modelObj = new AdvancedAccount;
            } else {
                $modelObj = new CashflowTransaction;
            }

            if ($request->approve_reject == 'approved') {
                $status = 1;
            } else {
                $status = 2;
            }

            $modelObj->where('id', $id)->update([
                'owner_approve_reject_at' => now(),
                'app_reject_note' => $request->app_reject_note,
                'owner_approval_status' => $status,
            ]);

            return response()->json([
                'success' => true,
                'message' => __('Voucher ').$request->approve_reject.__(' Successfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update voucher'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getPaymentModes(): JsonResponse
    {
        if (auth()->user()->role_id != Role::OWNER) {
            return response()->json([
                'success' => false,
                'message' => __('You are not authorized to do this action.'),
            ], 400);
        }

        $payment_mode = $this->service->paymentModes();
        $payment_mode->prepend(['id' => 0, 'name' => 'All Account']);

        return response()->json(['data' => $payment_mode->toArray()]);
    }

    public function voucherDetail($id, Request $request)
    {
        $request->validate(['type' => 'required']);

        if (! in_array(auth()->user()->role_id, [Role::OWNER, Role::CUSTOMER])) {
            return response()->json([
                'success' => false,
                'message' => __('You are not authorized to do this action.'),
            ], 400);
        }

        $type = $request->type;
        $data = $this->service->show($id, $type);

        return $type === 'advanced' ? new AdvancedVoucherResource($data) :
            ($type === 'invoice' ? new InvoiceVoucherResource($data) : new CashflowVoucherResource($data));
    }

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

    public function invoicePaymentReceipt(Request $request): Response
    {
        $paymentId = $request->get('invoice_payment_id');
        $invoicePayment = InvoicePayment::with('invoice.customer')
            ->where('id', $paymentId)
            ->firstOrFail();

        $invoiceData = [];
        if ($invoicePayment) {
            $invoiceData = InvoicePayment::with('invoice')
                ->whereIn('id', $invoicePayment->group_payment_ids ?? [$paymentId])
                ->get();
        }

        $pdf = PDF::loadView('vouchers.multi_payment_invoice_receipt', compact('invoiceData', 'invoicePayment'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream('Receipt_Voucher_Invoice_'.$invoicePayment->invoice->invoice_id_str.'.pdf');
    }

    public function advancedPaymentReceipt($id): Response
    {
        $invoicePayment = AdvancedAccount::where('id', $id)->first();

        $pdf = PDF::loadView('pending_voucher.templates.receipt_pdf', compact('invoicePayment'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream(($invoicePayment->amount > 0 ? 'Receipt' : 'Payment').'_Voucher_Advance_Payment_'.$invoicePayment->voucher_no.'.pdf');
    }
}
