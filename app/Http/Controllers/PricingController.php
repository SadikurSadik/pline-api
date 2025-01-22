<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Enums\VisibilityStatus;
use App\Http\Resources\Pricing\PricingResource;
use App\Models\Customer;
use App\Models\PricingPdf;
use App\Models\ShippingRate;
use App\Models\SystemSetting;
use App\Models\TowingRate;
use App\Services\ShippingRateService;
use App\Services\TowingRateService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function shippingPricePdfGenerate()
    {
        $data = $this->generatePdf();

//        try {
//            if (empty($data)) {
//                return response()->json(['success' => false, 'data' => []]);
//            }
//
//            $previousPdf = PricingPdf::orderBy('id', 'desc')->first();
//
//            if ($previousPdf) {
//                $previousPdf->update([
//                    'expire_at' => Carbon::now(),
//                ]);
//            }
//            $data['user_id'] = auth()->user()->id;
//
//            PricingPdf::create($data);
//
//            $url = url('/pricing-canada');
//
//            return response()->json([
//                'success' => true,
//                'message' => 'Success! Pdf Generate successfully',
//                'data' => $url
//            ]);
//        } catch (\Exception $e) {
//
//        }

    }

    public function generatePdf()
    {
        set_time_limit(100);
        ini_set('memory_limit', -1);

        $date = Carbon::parse(now())->format('d F Y');
        $data = app(ShippingRate::class)->all()->keyby('from_yard_id');
        $yard_ids = $data->pluck('from_yard_id')->toArray();

        $clearance_rate = optional(SystemSetting::where('name', 'clearance_rate')->first())->value;
        $profit_rate = optional(SystemSetting::where('name', 'profit')->first())->value;

        $filterArray = [
            'status' => VisibilityStatus::ACTIVE?->value,
//            'location_ids' => $yard_ids,
            'limit' => '-1',
        ];

        $towing_rates = app(TowingRateService::class)->all($filterArray)->sortBy('location_id')->groupby('location_id');

        $response = [];
        $prepareArray = [];

//        $terms_conditions = Page::where([
//            'caption' => 'PDF_TERMS_CONDITIONS',
//            'status' => VisibilityStatus::ACTIVE,
//        ])->first();
//
//        $title_type_pdf = Page::where([
//            'caption' => 'PDF_TITLE_TYPE_TABLE',
//            'status' => VisibilityStatus::ACTIVE,
//        ])->first();

        foreach (['a', 'b'] as $category) {
            $index = 0;
            foreach ($towing_rates as $items) {
                $prepareArray[$index]['location_id'] = data_get($items->first(), 'location.id');
                $prepareArray[$index]['location_name'] = data_get($items->first(), 'location.name');
                $prepareArray[$index]['state_name'] = data_get($items->first(), 'location.state.name');

                $prices = [];
                foreach ($items as $i => $towing_rate) {
                    $shipping_price = $data[$towing_rate->location_id]->{'rate_'.$category} / 4;
                    $towing_price = $towing_rate->{'rate_'.$category};
                    $prices[$i]['state_short_code'] = data_get($towing_rate, 'state.short_code');
                    $prices[$i]['city_name'] = data_get($towing_rate, 'city.name');
                    $prices[$i]['price'] = $shipping_price + $clearance_rate + $profit_rate + $towing_price;
                }
                $prepareArray[$index]['prices'] = $prices;
                $index++;
            }

            $pdf = PDF::loadView('pricing.template.shipping_pdf', compact('date', 'prepareArray'))
                ->setPaper('a4', 'portrait')
                ->setOptions(['defaultFont' => 'sans-serif'])->stream();
//
//            $response['pdf_url_'.$category] = 'uploads/pricing/documents/'.time().'_'.uniqid().'_shipping'.'.pdf';
//
//            Storage::put($response['pdf_url_'.$category], $pdf->output());
//            Storage::setVisibility($response['pdf_url_'.$category], 'public');
        }

        return $pdf;
    }
}
