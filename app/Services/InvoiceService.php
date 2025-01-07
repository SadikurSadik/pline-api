<?php

namespace App\Services;

use App\Enums\AdvancedAccountType;
use App\Models\Accounting\AdvancedAccount;
use App\Models\Accounting\Customer;
use App\Models\Accounting\Invoice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceService
{
    public function all($filters = [], $id = null, $type = 'inventory'): LengthAwarePaginator
    {
        $query = Invoice::with(['inventory', 'items', 'customer'])->where('status', '>', 0);

        if ($id) {
            $customer = Customer::where('customer_user_id', $id)->firstOrFail();
            $query->where('customer_id', $customer->customer_id);
        }

        if ($type) {
            $query->where('ak_type', $type);
        }

        if (isset($filters['status'])) {
            $query->whereIn('status', explode(',', $filters['status']));
        }

        if (isset($filters['invoice_global_search'])) {
            if (Str::startsWith($filters['invoice_global_search'], 'ARO')) {
                $query->where('invoice_id_str', '=', $filters['invoice_global_search']);
            } else {
                $query->where(function ($query) use ($filters) {
                    $query->whereHas('inventory', function ($q) use ($filters) {
                        $q->where(DB::raw('LOWER(name)'), 'LIKE', '%'.strtolower($filters['invoice_global_search']).'%')
                            ->orWhere(DB::raw('LOWER(sku)'), 'LIKE', '%'.strtolower($filters['invoice_global_search']).'%');
                    });
                });
            }
        }
        $limit = Arr::get($filters, 'limit', 50);

        return $query->orderBy('id', 'desc')->paginate($limit);
    }

    public function invoiceSummary(array $filters = []): array
    {
        $query = Invoice::with(['inventory', 'items'])->where('status', '>', 0);

        if (! empty($filters['customer_id'])) {
            $customer = Customer::where('customer_user_id', $filters['customer_id'])->firstOrFail();
            $query->where('customer_id', $customer->customer_id);
        }

        if (! empty($filters['type'])) {
            $query->where('ak_type', $filters['type']);
        }

        return [
            'total_amount' => $query->sum(DB::raw('total_amount')),
            'total_paid' => $query->sum(DB::raw('total_paid')),
            'total_due' => $query->sum(DB::raw('total_due')),
            'total_due_aed' => $query->sum(DB::raw('total_due * aed_rate')),
        ];
    }

    public function advancePaymentSummary(array $filters = []): array
    {
        $customer = Customer::where('customer_user_id', $filters['customer_id'])->first();
        $query = AdvancedAccount::where([
            'customer_id' => $customer?->customer_id ?? 0,
            'status' => 2, // approved
        ]);
        $query2 = clone $query;

        $data = [
            'total_amount' => $query->where('amount', '>', 0)->sum('amount'),
            'total_utilized' => abs($query2->where('amount', '<', 0)->sum('amount')),
        ];
        $data['total_due'] = $data['total_amount'] - $data['total_utilized'];

        return $data;
    }
}
