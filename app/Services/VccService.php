<?php

namespace App\Services;

use App\Enums\VccRegistrationType;
use App\Enums\VccStatus;
use App\Filters\FilterByArrivedDateOnVehicleContainerRelation;
use App\Filters\FilterByCustomerUserOnVehicleRelation;
use App\Filters\FilterByDeclarationDate;
use App\Filters\FilterByDeclarationNumber;
use App\Filters\FilterByHandedOverTo;
use App\Filters\FilterByLotNumberOnVehicleRelation;
use App\Filters\FilterByReceivedDate;
use App\Filters\FilterByServiceProviderOnVehicleRelation;
use App\Filters\FilterByStatus;
use App\Filters\FilterByVccGlobalSearch;
use App\Filters\FilterByVehicleRegistrationType;
use App\Filters\FilterByVinNumberOnVehicleRelation;
use App\Models\Vcc;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class VccService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Vcc::with(['vehicle.customer', 'container', 'exit_paper', 'issued_by']);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByVccGlobalSearch::class,
            FilterByCustomerUserOnVehicleRelation::class,
            FilterByVinNumberOnVehicleRelation::class,
            FilterByServiceProviderOnVehicleRelation::class,
            FilterByArrivedDateOnVehicleContainerRelation::class,
            FilterByLotNumberOnVehicleRelation::class,
            FilterByDeclarationNumber::class,
            FilterByDeclarationDate::class,
            FilterByStatus::class,
            FilterByVehicleRegistrationType::class,
            FilterByReceivedDate::class,
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

    public function updateContainerBgColor($containerId): void
    {
        $colors = [
            'yellow' => '#FDEB37',
            'green' => '#34A834',
            'red' => '#FF474C',
        ];
        $colorName = 'yellow';

        $vccs = Vcc::with('exit_paper')
            ->where(['container_id' => $containerId])
            ->get();

        if ($vccs->count() > 0 && $vccs->where('vehicle_registration_type', VccRegistrationType::EXIT)->count() === $vccs->count()) {
            $received = 0;
            $submitted = 0;
            $vccs->map(function ($vcc) use (&$received, &$submitted) {
                if ($vcc->exit_paper && $vcc->exit_paper->status == VccStatus::EXIT_PAPER_SUBMITTED) {
                    $submitted++;
                }
                if ($vcc->exit_paper && $vcc->exit_paper->status == VccStatus::EXIT_PAPER_RECEIVED) {
                    $received++;
                }
            });
            if ($submitted === $vccs->count()) {
                $colorName = 'red';
            } elseif ($received + $submitted >= $vccs->count()) {
                $colorName = 'green';
            }
        }

        Vcc::query()->where('container_id', $containerId)->update(['container_bg_color' => $colors[$colorName]]);
    }
}
