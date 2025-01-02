<?php

namespace App\Services;

use App\Enums\VccStatus;
use App\Filters\FilterByDeclarationNumber;
use App\Filters\FilterByHandedOverTo;
use App\Filters\FilterByReceivedDate;
use App\Filters\FilterByStatus;
use App\Filters\FilterByVehicleRegistrationType;
use App\Models\Vcc;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class VccService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Vcc::with(['vehicle', 'vehicle.customer', 'container', 'exit_paper', 'issued_by']);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByReceivedDate::class,
            FilterByDeclarationNumber::class,
            FilterByVehicleRegistrationType::class,
            FilterByHandedOverTo::class,
        ], $filters);
    }

    public function getById($id)
    {
        return Vcc::with([
            'vehicle.customer',
            'container',
            'exit_paper',
            'issued_by',
        ])->findOrFail($id);
    }

    public function destroy($id): void
    {
        $vcc = Vcc::findOrFail($id);

        $vcc->delete();
    }

    public function store(array $data)
    {
        return $this->saveVcc($data);
    }

    public function update($id, array $data)
    {
        return $this->saveVcc($data, $id);
    }

    private function saveVcc($data, $id = null)
    {
        unset($data['status']);
        $vcc = Vcc::findOrNew($id);
        $vcc->fill($data);
        if (! empty($data['received_date'])) {
            $vcc->expire_date = Carbon::parse($data['received_date'])->addDays(180)->format('Y-m-d');
        }

        if ($vcc->status == 0 && ! empty($vcc->declaration_number) && isset($data['in_hand'])) {
            $vcc->status = VccStatus::ON_HAND;
        }

        if ($vcc->exit_paper && $vcc->exit_paper->status === VccStatus::EXIT_PAPER_SUBMITTED) {
            $vcc->exit_paper->update([
                'amount_received_in_bank' => $data['amount_received_in_bank'],
                'date_amount_received_in_bank' => $data['date_amount_received_in_bank'],
            ]);

            $exitPaperData = array_merge($vcc->exit_paper->toArray(), [
                'amount_received_in_bank' => $data['amount_received_in_bank'],
                'date_amount_received_in_bank' => $data['date_amount_received_in_bank'],
            ]);
            $vcc->vcc_exit_data = $exitPaperData;
        }

        $vcc->save();

        return $vcc;
    }

    public function vccDetail(int $id): Collection
    {
        return Vcc::query()->where([
            'container_id' => $id,
            'status' => 0,
        ])->get();
    }
}
