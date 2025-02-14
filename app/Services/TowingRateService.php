<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByCity;
use App\Filters\FilterByCountry;
use App\Filters\FilterById;
use App\Filters\FilterByLocation;
use App\Filters\FilterByLocationIds;
use App\Filters\FilterByRate;
use App\Filters\FilterByRateA;
use App\Filters\FilterByRateB;
use App\Filters\FilterByState;
use App\Filters\FilterByStatus;
use App\Filters\FilterByTowingRateGlobalSearch;
use App\Models\TowingRate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class TowingRateService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder|Collection
    {
        $query = TowingRate::with([
            'country',
            'state',
            'city',
            'location',
        ]);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByRate::class,
            FilterByRateA::class,
            FilterByRateB::class,
            FilterByCountry::class,
            FilterByState::class,
            FilterByCity::class,
            FilterByLocation::class,
            FilterByLocationIds::class,
            FilterByStatus::class,
            FilterById::class,
            FilterByTowingRateGlobalSearch::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return TowingRate::with([
            'country',
            'state',
            'city',
            'location',
        ])->findOrFail($id);
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
        $data['status'] = Arr::get($data, 'status') == VisibilityStatus::ACTIVE->value ?
            VisibilityStatus::ACTIVE->value : VisibilityStatus::INACTIVE->value;
        $towingRate = TowingRate::findOrNew($id);
        $towingRate->fill($data);
        $towingRate->save();

        return $towingRate;
    }

    public function destroy(int $id): void
    {
        $towingRate = TowingRate::findOrFail($id);

        $towingRate->delete();
    }
}
