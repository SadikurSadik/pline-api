<?php

namespace App\Http\Controllers;

use App\Enums\DamageClaimStatus;
use App\Exports\DamageClaimsExport;
use App\Http\Requests\DamageClaim\StoreDamageClaimRequest;
use App\Http\Requests\DamageClaim\UpdateDamageClaimRequest;
use App\Http\Resources\DamageClaim\DamageClaimDetailResource;
use App\Http\Resources\DamageClaim\DamageClaimResource;
use App\Models\DamageClaim;
use App\Services\DamageClaimService;
use App\Services\FileManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DamageClaimController extends Controller implements HasMiddleware
{
    public function __construct(protected DamageClaimService $service) {}

    public static function middleware(): array
    {
        return [
            new Middleware('role_or_permission:owner|manage damage claim', only: ['index']),
            new Middleware('role_or_permission:owner|create damage claim', only: ['store']),
            new Middleware('role_or_permission:owner|update damage claim', only: ['update']),
            new Middleware('role_or_permission:owner|view damage claim', only: ['show']),
            new Middleware('role_or_permission:owner|delete damage claim', only: ['destroy']),
            new Middleware('role_or_permission:owner|export excel damage claim', only: ['exportExcel']),
        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return DamageClaimResource::collection($data);
    }

    public function store(StoreDamageClaimRequest $request): JsonResponse
    {
        $this->service->store($request->validated());

        return successResponse(__('Damage claimed successfully.'));
    }

    public function show($id): DamageClaimDetailResource
    {
        $data = $this->service->getById($id);

        return new DamageClaimDetailResource($data);
    }

    public function update(UpdateDamageClaimRequest $request, string $id): JsonResponse
    {
        $this->service->update($id, $request->validated());

        return successResponse(__('Damage Claim updated successfully.'));
    }

    public function destroy(string $id): JsonResponse
    {
        $claim = $this->service->getById($id);
        if ($claim->status != DamageClaimStatus::Approved) {
            return errorResponse(__('Only Rejected damage claims are allowed to delete!'));
        }

        $this->service->destroy($id);

        return successResponse(__('Damage Claim deleted successfully.'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new DamageClaimsExport($request->all()), 'damage_claims.xlsx');
    }

    public function uploadPhoto(Request $request, FileManagerService $fileStorage): JsonResponse
    {
        $request->validate([
            'photo' => 'required|image',
        ]);

        try {
            $upload = $fileStorage->uploadPhoto(file_get_contents($request->file), 'uploads/damage-claims');

            if (! $upload) {
                return response()->json(['success' => false, 'url' => null, 'message' => 'Failed to file upload'], 400);
            }

            return response()->json(['success' => true, 'url' => $upload]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile file.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function downloadDamageClaimPhotos(
        $id,
        FileManagerService $fileManagerService
    ): BinaryFileResponse|JsonResponse {
        $photos = $this->service->getById($id)?->photos;

        $zipFileName = 'damage_claim_photos_'.date('Y-m-d').'.zip';
        $zipPath = storage_path("app/public/uploads/{$zipFileName}");

        return $fileManagerService->downloadAsZip($zipPath, $photos);
    }

    public function damageClaimApprove(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'approved_amount' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        try {
            $this->service->approveDamageClaim($data, $id);

            return successResponse(__('Damage Claimed approved successfully.'));
        } catch (\Exception $exception) {
            Log::error('Damage claim approve exception: '.$exception->getMessage());

            return errorResponse(__('Something Wrong'));
        }
    }

    public function damageClaimReject(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'note' => 'required|string|max:250',
        ]);

        try {
            $this->service->rejectDamageClaim($data, $id);

            return successResponse(__('Damage Claimed rejected successfully.'));
        } catch (\Exception $exception) {
            Log::error('Damage claim reject exception: '.$exception->getMessage());

            return errorResponse(__('Something Wrong'));
        }
    }

    public function printAsPdfVoucher($id)
    {
        $data = DamageClaim::with('vehicle.customer')->findOrFail($id);
        if ($data->status != DamageClaimStatus::Approved) {
            return errorResponse(__('Only Approved damage claims are allowed to print voucher!'));
        }

        $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView('damage-claim.voucher_pdf', compact('data'), [], [
            'format' => 'A4',
            'defaultFont' => 'sans-serif',
            'isRemoteEnabled' => true,
        ]);

        $fileName = 'Damage_Claim_Voucher_'.str_pad($data->id, 5, '0', STR_PAD_LEFT).'.pdf';

        return $pdf->stream($fileName);
    }
}
