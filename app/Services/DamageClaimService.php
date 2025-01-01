<?php

namespace App\Services;

use App\Enums\DamageClaimStatus;
use App\Filters\FilterByCustomerUser;
use App\Filters\FilterByStatus;
use App\Filters\FilterByVinOnVehicleRelation;
use App\Models\DamageClaim;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DamageClaimService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = DamageClaim::with('user');

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByCustomerUser::class,
            FilterByVinOnVehicleRelation::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return DamageClaim::with(['user', 'vehicle'])->find($id);
    }

    public function store(array $data)
    {
        return $this->save($data);
    }

    public function update(int $id, array $data)
    {
        return $this->save($data, $id);
    }

    private function save(array $data, ?int $id = null)
    {
        $damageClaim = DamageClaim::findOrNew($id);
        $damageClaim->fill($data);
        $damageClaim->photos = trimHostFromUrls($data['photos'], env('APP_MEDIA_URL'));

        $damageClaim->save();

        return $damageClaim;
    }

    public function destroy(int $id): void
    {
        $damageClaim = DamageClaim::findOrFail($id);

        $damageClaim->delete();
    }

    public function approveDamageClaim($data, $id): void
    {
        $damageClaim = DamageClaim::findOrFail($id);
        $damageClaim->approved_amount = (int) $data['approved_amount'];
        $damageClaim->note = $data['note'];
        $damageClaim->status = DamageClaimStatus::Approved;
        $damageClaim->approve_reject_by = Auth::user()->id;
        $damageClaim->approve_reject_at = Carbon::now();
        $damageClaim->save();
    }

    public function rejectDamageClaim($data, $id): void
    {
        $damageClaim = DamageClaim::findOrFail($id);
        $damageClaim->note = $data['note'];
        $damageClaim->status = DamageClaimStatus::Rejected;
        $damageClaim->approve_reject_by = Auth::user()->id;
        $damageClaim->approve_reject_at = Carbon::now();
        $damageClaim->save();
    }
}
