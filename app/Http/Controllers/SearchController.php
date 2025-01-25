<?php

namespace App\Http\Controllers;

use App\Enums\VehicleStatus;
use App\Enums\VisibilityStatus;
use App\Models\City;
use App\Models\Condition;
use App\Models\Consignee;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Feature;
use App\Models\Location;
use App\Models\Port;
use App\Models\State;
use App\Models\TitleType;
use App\Models\Vehicle;
use App\Models\VehicleColor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    public function searchCountry(Request $request): JsonResponse
    {
        $query = Country::select([
            'id',
            'name',
        ])->where('status', VisibilityStatus::ACTIVE);

        if (! empty($request->export_vehicle)) {
            $query->where('export_vehicle', $request->export_vehicle);
        }

        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('short_code', 'like', "%{$request->search}%");
        }

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchState(Request $request): JsonResponse
    {
        $query = State::select([
            'id',
            'short_code',
            'name',
        ])->where('status', VisibilityStatus::ACTIVE);
        if (! empty($request->country_id)) {
            $query->where('country_id', $request->country_id);
        }
        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('short_code', 'like', "%{$request->search}%");
        }

        return response()->json(['data' => $query->limit(50)->get()]);
    }

    public function searchCity(Request $request): JsonResponse
    {
        $query = City::select(['id', 'name'])
            ->where('status', VisibilityStatus::ACTIVE);

        if (! empty($request->state_id)) {
            $query->where('state_id', $request->state_id);
        }
        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('short_code', 'like', "%{$request->search}%");
        }

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchLocation(Request $request): JsonResponse
    {
        $query = Location::select(['id', 'name'])
            ->where('status', VisibilityStatus::ACTIVE);

        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchPort(Request $request): JsonResponse
    {
        $query = Port::select(['id', 'name'])
            ->where('status', VisibilityStatus::ACTIVE);

        if (! empty($request->country_id)) {
            $query->where('country_id', $request->country_id);
        }

        if (! empty($request->state_id)) {
            $query->where('state_id', $request->state_id);
        }

        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchTitleTypes(Request $request): JsonResponse
    {
        $query = TitleType::select(['id', 'name'])
            ->where('status', VisibilityStatus::ACTIVE);

        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchRole(Request $request)
    {
        $query = Role::select([
            'id',
            'name',
        ]);
        if (! empty($request->exclude_ids)) {
            $query->whereNotIn('id', explode(',', $request->exclude_ids));
        }
        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return $query->get();
    }

    public function searchCustomer(Request $request)
    {
        $query = Customer::select([
            DB::raw('user_id as id'),
            'customer_id',
            'name',
            'company_name',
        ]);

        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return $query->limit(20)->get();
    }

    public function searchBuyerNumbers($customerUserId)
    {
        $customer = Customer::where('user_id', $customerUserId)->firstOrFail();

        return $customer->buyer_ids ?? [];
    }

    public function searchColor(Request $request)
    {
        $query = VehicleColor::select([
            'id',
            'name',
        ]);
        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return $query->orderBy('name', 'ASC')
            ->limit(20)
            ->get()
            ->map(function ($item) {
                return ['id' => $item->name, 'name' => $item->name];
            });
    }

    public function searchVehicleCondition()
    {
        return Condition::select('id', 'name')->get();
    }

    public function searchVehicleFeature()
    {
        return Feature::select('id', 'name')->get();
    }

    public function searchVehicle(Request $request)
    {
        $query = Vehicle::select([
            'id',
            DB::raw('vin_number AS name'),
        ])->where('status', VehicleStatus::ON_HAND->value)
            ->whereNull('container_id');

        if (! empty($filters['exclude_ids'])) {
            $query->whereNotIn('id', $filters['exclude_ids']);
        }

        if (! empty($vehicle->vin)) {
            $query->where('vin_number', 'like', "%{$vehicle->vin}%");
        }

        return $query->limit(20)->get();
    }

    public function searchConsignee(Request $request)
    {
        $query = Consignee::select('id', 'name');

        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return $query->orderBy('name', 'ASC')
            ->limit('20')
            ->get();
    }
}
