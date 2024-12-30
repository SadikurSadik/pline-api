<?php

namespace App\Http\Controllers;

use App\Enums\VisibilityStatus;
use App\Models\City;
use App\Models\Country;
use App\Models\Location;
use App\Models\Port;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    public function searchCountry(Request $request): JsonResponse
    {
        $query = Country::select([
            'id',
            'name',
        ])->where('status', VisibilityStatus::ACTIVE);

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
            'name',
        ])->where('status', VisibilityStatus::ACTIVE);
        if (! empty($request->country_id)) {
            $query->where('country_id', $request->country_id);
        }
        if (! empty($request->search)) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('short_code', 'like', "%{$request->search}%");
        }

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchCity(Request $request): JsonResponse
    {
        $query = City::select(['id', 'name', ])
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
        $query = Location::select(['id', 'name', ])
            ->where('status', VisibilityStatus::ACTIVE);

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchPort(Request $request): JsonResponse
    {
        $query = Port::select(['id', 'name', ])
            ->where('status', VisibilityStatus::ACTIVE);

        if (! empty($request->country_id)) {
            $query->where('country_id', $request->country_id);
        }

        if (! empty($request->state_id)) {
            $query->where('state_id', $request->state_id);
        }

        return response()->json(['data' => $query->limit(20)->get()]);
    }

    public function searchRole(Request $request): JsonResponse
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
}
