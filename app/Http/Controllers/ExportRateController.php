<?php

namespace App\Http\Controllers;

use App\Enums\PricingType;
use App\Enums\VisibilityStatus;
use App\Exports\ExportRatesExport;
use App\Http\Requests\ExportRate\StoreExportRate;
use App\Http\Requests\ExportRate\UpdateExportRate;
use App\Http\Resources\ExportRate\ExportRateResource;
use App\Models\PricingPdf;
use App\Services\ExportRateService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportRateController extends Controller
{
    public function __construct(protected ExportRateService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage export rate', only: ['index']),
            new Middleware('role_or_permission:owner|create export rate', only: ['store']),
            new Middleware('role_or_permission:owner|update export rate', only: ['update']),
            new Middleware('role_or_permission:owner|view export rate', only: ['show']),
            new Middleware('role_or_permission:owner|delete export rate', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel export rate', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return ExportRateResource::collection($data);
    }

    public function store(StoreExportRate $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Export Rate added Successfully.'));
    }

    public function show($id): ExportRateResource
    {
        $data = $this->service->getById($id);

        return new ExportRateResource($data);
    }

    public function update($id, UpdateExportRate $request): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Export Rate updated Successfully.'));
    }

    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);

        return successResponse(__('Export Rate deleted Successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new ExportRatesExport($request->all()), 'vehicle_export_rates.xlsx');
    }

    public function generatePricing()
    {
        $data = $this->generatePdf();

        try {
            if (empty($data)) {
                return response()->json(['success' => false, 'data' => []]);
            }

            $previousPdf = PricingPdf::orderBy('id', 'desc')->first();

            if ($previousPdf) {
                $previousPdf->update([
                    'expire_at' => Carbon::now(),
                ]);
            }
            $data['user_id'] = auth()->user()?->id;
            $data['type'] = PricingType::EXPORT->value;

            PricingPdf::create($data);

            return apiResponse('Success! Pricing Generate successfully');
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Failed! Unable to Generate pricing.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function generatePdf()
    {
        set_time_limit(100);
        ini_set('memory_limit', '-1');

        $date = Carbon::parse(now())->format('d F Y');

        $filterArray = [
            'status' => VisibilityStatus::ACTIVE?->value,
            'limit' => '-1',
        ];

        $exportRates = app(ExportRateService::class)->all($filterArray);

        $response = [];
        $prepareArray = [];

        foreach (['a', 'b'] as $category) {
            $index = 0;
            $prices = [];
            foreach ($exportRates as $i => $exportRate) {
                $exportPrice = $exportRate->{'rate_'.$category};
                $prices[$i]['departure_country'] = data_get($exportRate, 'from_country.name');
                $prices[$i]['destination_country'] = data_get($exportRate, 'to_country.name');
                $prices[$i]['price'] = $exportPrice;
            }
            $index++;
            $prepareArray[$index]['prices'] = $prices;

            $pdf = PDF::loadView('pricing.template.export_pdf', compact('date', 'prepareArray'))
                ->setPaper('a4', 'portrait')
                ->setOptions(['defaultFont' => 'sans-serif']);

            $response['pdf_url_'.$category] = 'uploads/pricing/documents/'.time().'_'.uniqid().'_export'.'.pdf';

            Storage::put($response['pdf_url_'.$category], $pdf->output());
            Storage::setVisibility($response['pdf_url_'.$category], 'public');
        }

        return $response;
    }
}
