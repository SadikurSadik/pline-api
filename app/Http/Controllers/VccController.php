<?php

namespace App\Http\Controllers;

use App\Enums\VccStatus;
use App\Exports\VccsExport;
use App\Http\Requests\Vcc\StoreVccAttachmentRequest;
use App\Http\Requests\Vcc\StoreVccDetailRequest;
use App\Http\Resources\Vcc\GetVccDetailResource;
use App\Http\Resources\Vcc\VccDetailResource;
use App\Http\Resources\Vcc\VccResource;
use App\Services\FileManagerService;
use App\Services\VccService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VccController extends Controller
{
    public function __construct(protected VccService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return VccResource::collection($data);
    }

    public function show($id): VccDetailResource
    {
        $data = $this->service->getById($id);

        return new VccDetailResource($data);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->destroy($id);

            return successResponse(__('VCC Deleted Successfully'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        ini_set('memory_limit', '2024M');

        return Excel::download(new VccsExport($request->all()), 'vcc.xlsx');
    }

    public function getVccDetail($id): AnonymousResourceCollection
    {
        $vccDetail = $this->service->vccDetail($id);

        return GetVccDetailResource::collection($vccDetail);
    }

    public function storeVccDetail($containerId, StoreVccDetailRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $commonData = $request->only(['declaration_number', 'declaration_date', 'received_date']);
            foreach ($request->custom_duty as $id => $dutyAmount) {
                $this->service->update(
                    $id,
                    array_merge(
                        $commonData,
                        [
                            'custom_duty' => $dutyAmount,
                            'in_hand' => array_key_exists($id, $data['in_hand']),
                        ]
                    )
                );
            }
            DB::commit();

            return successResponse(__('VCC detail added successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('store vcc detail: '.$e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }

    public function uploadVccAttachment(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required',
        ]);

        try {
            $upload = app(FileManagerService::class)->upload($request->file, 'uploads/vcc/attachment');

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

    public function storeVccAttachment($id, StoreVccAttachmentRequest $request): JsonResponse
    {
        $data = $request->only(['vcc_attachment', 'bill_of_entry_attachment', 'other_attachment']);

        try {
            $this->service->update($id, $data);

            return successResponse(__('VCC attachment added successfully.'));
        } catch (\Exception $e) {
            Log::error('store vcc attachment: '.$e->getMessage());

            return errorResponse(__('Failed! Something went wrong.'));
        }
    }

    public function VccReset($id): JsonResponse
    {
        $vcc = $this->service->getById($id);

        if ($vcc && $vcc->status != VccStatus::HANDED_OVER) {
            return errorResponse(__('VCC not in Handed Over Status.'));
        }

        try {
            DB::transaction(function () use ($vcc) {
                if ($vcc->exit_paper) {
                    $vcc->exit_paper->delete();
                }
                $vcc->update([
                    'status' => VccStatus::ON_HAND,
                    'deposit_amount' => null,
                    'handed_over_to' => null,
                    'vehicle_registration_type' => null,
                    'issued_by' => null,
                    'issued_at' => null,
                    'handed_over_by' => null,
                    'handed_over_at' => null,
                    'vcc_exit_data' => [],
                ]);
            });
            $this->service->updateContainerBgColor($vcc->container_id);

            return successResponse(__('Success! VCC reset successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            return errorResponse(__('Failed! VCC reset failed.'));
        }
    }
}
