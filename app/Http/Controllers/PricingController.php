<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Enums\VisibilityStatus;
use App\Http\Resources\Pricing\PricingResource;
use App\Models\Customer;
use App\Models\PricingPdf;
use App\Models\SystemSetting;
use App\Services\ShippingRateService;
use App\Services\TowingRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $category = 'a';
        if (optional(auth()->user())->role === Role::CUSTOMER) {
            $customer = Customer::where('user_id', auth()->user()->id)->firstOrFail();
            if (in_array($customer->category, ['a', 'b'])) {
                $category = $customer->category;
            }
        }

        $data = PricingPdf::select([
            'id',
            DB::raw("pdf_url_{$category} AS pdf_url"),
            'expire_at',
            'created_at',
        ])->orderBy('id', 'desc')
            ->get();

        return PricingResource::collection($data);
    }

    public function destroy($id): JsonResponse
    {
        if (optional(auth()->user())->role_id != Role::OWNER) {
            return errorResponse(__("You don't have permission do this action"));
        }

        PricingPdf::where('id', $id)->delete();

        return successResponse('Pricing pdf deleted successfully');
    }

    public function pricingPerVehicle(Request $request): JsonResponse
    {
        $response = Cache::remember('pricing_api', 3, function () use ($request) {
            $category = 'a';

            $data = app(ShippingRateService::class)->all()->keyby('from_yard_id');
            $yard_ids = $data->pluck('from_yard_id')->toArray();

            $clearance_rate = optional(SystemSetting::where('name', 'clearance_rate')->first())->value;
            $profit_rate = optional(SystemSetting::where('name', 'profit')->first())->value;

            $filterArray = [
                'status' => VisibilityStatus::ACTIVE->value,
                'location_ids' => $yard_ids,
                'limit' => '-1',
            ];

            if ($request->get('city_id')) {
                $filterArray['city_id'] = $request->get('city_id');
            }

            $towing_rates = app(TowingRateService::class)->all($filterArray)->groupby('state_id');
            $responseData = [];
            foreach ($towing_rates as $key => $items) {
                $cities = [];
                foreach ($items as $towing_rate) {
                    $shipping_price = $data[$towing_rate->location_id]->{'rate_'.$category} / 4;
                    $towing_price = $towing_rate->{'rate_'.$category};
                    dd($shipping_price, $towing_price);
                    $cities[] = ['id' => $towing_rate->city_id, 'name' => data_get($towing_rate, 'city.name'), 'state_code' => data_get($towing_rate, 'city.state.short_code'), 'price' => ($shipping_price + $clearance_rate + $profit_rate + $towing_price)];
                }
                $responseData[] = [
                    'id' => $key,
                    'name' => optional($items->first())->state?->name,
                    'yard_name' => data_get($items->first(), 'location.name'),
                    'cities' => $cities,
                ];
            }

            return $responseData;
        });

        return response()->json(['success' => true, 'data' => $response]);
    }
}
