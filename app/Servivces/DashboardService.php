<?php

namespace App\Servivces;

use App\Enums\Role;
use App\Enums\VehicleStatus;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function vehicleCounts($filters = []): array
    {
        $data = [];
        foreach (config('vehicle.statuses') as $item) {
            if (optional(auth()->user())->role_id === Role::ADMIN && ! in_array($item['status'],
                [VehicleStatus::ON_HAND, VehicleStatus::ON_THE_WAY])) {
                continue;
            }
            $dataArr = array_merge($item, ['total' => $this->getCounts($filters, $item['status'])]);
            $dataArr = array_merge($dataArr, ['logo' => url($item['logo'])]);

            $data[] = $dataArr;
        }

        return $data;
    }

    public function getCounts($filters = [], $status = null): int
    {
        $query = Vehicle::query();

        if (! empty($filters['user_id'])) {
            $query->where('customer_user_id', $filters['user_id']);
        }

        if (! empty($filters['location_id'])) {
            $query->where('location_id', $filters['location_id']);
        }

        if (optional(auth()->user())->role_id == Role::SUB_USER) {
            $query->where([
                'vehicles.customer_user_id' => auth()->user()->parent_id,
                'assigned_to' => auth()->user()->id,
            ]);
        }

        if (optional(auth()->user())->role_id == Role::ADMIN) {
            $query->whereIn('location_id', auth()->user()->locations);
        }

        if (optional(auth()->user())->customers) {
            $query->whereHas('customer', function ($q) {
                $q->whereIn('legacy_customer_id', auth()->user()->customers);
            });
        }

        if ($status != '' && $status != null) {
            $query->where('status', $status);
        }

        return $query->count();
    }

    public function monthlySales($filters = [])
    {
        $query = Vehicle::select([
            DB::raw("date_format(created_at,'%Y') AS `year`"),
            DB::raw("date_format(created_at,'%b') AS `month`"),
            DB::raw('COUNT(id) AS count'),
        ]);

        if (optional(auth()->user())->role_id == Role::ADMIN) {
            $query->whereIn('location_id', auth()->user()->locations);
        }

        if (optional(auth()->user())->role_id == Role::CUSTOMER) {
            $query->where('customer_user_id', auth()->user()->id);
        } elseif (! empty($filters['customer_user_id'])) {
            $query->where('customer_user_id', $filters['customer_user_id']);
        }

        if (optional(auth()->user())->role_id == Role::SUB_USER) {
            $query->where([
                'vehicles.customer_user_id' => auth()->user()->parent_id,
                'assigned_to' => auth()->user()->id,
            ]);
        }

        $query->groupBy([DB::raw('year(created_at)'), DB::raw('month(created_at)')])
            ->orderBy(DB::raw('year(created_at)'), 'DESC')
            ->orderBy(DB::raw('month(created_at)'));

        return $query->get();
    }
}
