<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Customer;
use App\Services\NotificationService;
use App\Servivces\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function dashboardMobileApi(Request $request)
    {
        $data = [
            'unread_notifications_count' => app(NotificationService::class)->myUnreadNotificationCount(),
            'pending_voucher_count' => 0 /*app(VoucherService::class)->getPendingVoucherCount()*/,
        ];
        /*if (optional(auth()->user())->role == Role::CUSTOMER) {
            $invoiceData = app(InvoiceService::class)->invoiceSmmary(['customer_id' => auth()->user()->id]);
            $data['invoice_total_amount'] = 'Total: AED '.number_format($invoiceData['total_amount'], 2);
            $total = $invoiceData['total_amount'];
            if (empty($total)) {
                $total = 100;
            }
            $data['invoice_summary'] = [
                [
                    'value' => number_format(($invoiceData['total_due'] * 100) / $total, 2),
                    'label' => 'Balance: AED '.number_format($invoiceData['total_due'], 2),
                    'color' => '#DC4C64',
                ],
                [
                    'value' => number_format(($invoiceData['total_paid'] * 100) / $total, 2),
                    'label' => 'Paid: AED '.number_format($invoiceData['total_paid'], 2),
                    'color' => '#14A44D',
                ],
            ];

            $advanceData = app(InvoiceService::class)->advancePaymentSmmary(['customer_id' => auth()->user()->id]);
            $data['advance_total_amount'] = 'Balance: AED '.number_format($advanceData['total_due'], 2);
            $total = $advanceData['total_amount'] + abs($advanceData['total_utilized']);
            if (empty($total)) {
                $total = 100;
            }
            $data['advance_summary'] = [
                [
                    'value' => number_format(abs($advanceData['total_utilized'] * 100) / $total, 2),
                    'label' => 'Utilized: AED '.number_format(abs($advanceData['total_utilized']), 2),
                    'color' => '#FF7F50',
                ],
                [
                    'value' => number_format(abs($advanceData['total_amount'] * 100) / $total, 2),
                    'label' => 'Deposit: AED '.number_format($advanceData['total_amount'], 2),
                    'color' => '#6495ED',
                ],
            ];
        }*/

        return response()->json($data);
    }

    public function statusOverview(Request $request): \Illuminate\Http\JsonResponse
    {
        $filters = $request->all();
        if (auth()->user()->role_id == Role::CUSTOMER) {
            $filters['user_id'] = auth()->user()->id;
        } elseif (! empty($filters['customer_id'])) {
            $customer = Customer::find($filters['customer_id']);
            if ($customer) {
                $filters['user_id'] = $customer->user_id;
            }
        }
        $data = $this->service->vehicleCounts($filters);

        return response()->json($data);
    }

    public function monthlySales(): array
    {
        $data = $this->service->monthlySales();
        $data = $data->groupBy('year');
        $years = $data->keys()->all();

        $items = $data->map(function ($item) {
            return ['months' => $item->pluck('month'), 'counts' => $item->pluck('count')];
        })->values();

        return ['years' => $years, 'data' => $items];
    }
}
