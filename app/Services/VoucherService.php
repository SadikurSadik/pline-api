<?php

namespace App\Services;

use App\Models\Accounting\AdvancedAccount;
use App\Models\Accounting\InvoicePayment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class VoucherService
{

    public function customerAdvanceVoucherList(array $filters = []): LengthAwarePaginator
    {
        $query = AdvancedAccount::query();

        if (! empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (! empty($filters['signature_required'])) {
            $query->where('signature_required', $filters['signature_required']);
        }

        if (! empty($filters['already_signed'])) {
            $query->whereNotNull('signed_at');
        }

        if (! empty($filters['type'])) {
            if ($filters['type'] == 1) {
                $query->where('amount', '>', 0);
            } elseif ($filters['type'] == 2) {
                $query->where('amount', '<', 0);
            }
        }

        if (! empty($filters['global_search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('voucher_no', $filters['global_search'])
                    ->orWhere('note', 'LIKE', '%'.$filters['global_search'].'%');
            });
        }

        return $query->orderBy('id', 'DESC')
            ->paginate(Arr::get($filters, 'limit', 20));
    }

    public function customerInvoiceVoucherList(array $filters = []): LengthAwarePaginator
    {
        $query = InvoicePayment::query()->with(['invoice.customer', 'bankAccount'])
            ->whereHas('invoice', function ($query) use ($filters) {
                if (! empty($filters['customer_id'])) {
                    $query->where('customer_id', $filters['customer_id']);
                }
                if (! empty($filters['type']) && in_array($filters['type'], ['inventory', 'service'])) {
                    $query->where('ak_type', '=', $filters['type']);
                }
            });

        if (! empty($filters['signature_required'])) {
            $query->where('signature_required', $filters['signature_required']);
        }

        if (! empty($filters['already_signed'])) {
            $query->whereNotNull('signed_at');
        }

        if (! empty($filters['global_search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('reference', $filters['global_search'])
                    ->orWhereHas('invoice.inventory', function ($query) use ($filters) {
                        $query->where('name', 'LIKE', '%'.$filters['global_search'].'%')
                            ->orWhere('sku', $filters['global_search']);
                    })
                    ->orWhere('description', 'LIKE', '%'.$filters['global_search'].'%');
            });
        }

        return $query->orderBy('id', 'DESC')
            ->paginate(Arr::get($filters, 'limit', 20));
    }
}
