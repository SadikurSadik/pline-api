<?php

namespace App\Http\Controllers;

use App\Enums\DamageClaimStatus;
use App\Enums\Role;
use App\Enums\VehicleStatus;
use App\Models\Customer;
use App\Models\DamageClaim;
use App\Services\ComplainService;
use App\Services\DashboardService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $filters = $request->all();
        if (optional(auth()->user())->role_id == Role::CUSTOMER) {
            $filters['user_id'] = auth()->user()->id;
        }

        $statusOverview = collect($this->service->vehicleCounts($filters))->whereNotIn('status', [0, VehicleStatus::LOADED->value, VehicleStatus::DISPATCHED->value])->values();

        $data = [
            'status_overview' => $statusOverview,
            //            'invoice_overview' => app( InvoiceService::class )->invoiceSummary( $filters ),
            'invoice_overview' => [],
            'userInfo' => $this->service->userInfo($request->all()),
            'counter' => [
                'notification' => app(NotificationService::class)->myUnreadNotificationCount(),
                'feedback' => 0,
                'complain' => app(ComplainService::class)->adminUnreadCount(),
                'damage_claims' => DamageClaim::where('status', DamageClaimStatus::Pending->value)
                    ->when(auth()->user()->role_id == Role::CUSTOMER, function ($query) {
                        $query->where('customer_user_id', auth()->user()->id);
                    })->count(),
                'storage_claims' => 0,
                'key_missing_claims' => 0,
            ],
        ];

        return response()->json($data);
    }

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

    public function vehicleStatusOverview(Request $request)
    {
        $filters = $request->all();
        if (optional(auth()->user())->role_id == Role::CUSTOMER) {
            $filters['user_id'] = auth()->user()->id;
        } elseif (optional(auth()->user())->role_id == Role::SUB_USER) {
            $filters['user_id'] = auth()->user()->parent_id;
        }

        return response()->json([
            'vehicles_statuses' => $this->service->vehicleCounts($filters),
            'unread_notifications_count' => app(\App\Services\NotificationService::class)->myUnreadNotificationCount(),
        ]);
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
