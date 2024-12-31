<?php

namespace App\Services;

use App\Filters\FilterByCity;
use App\Filters\FilterByCountry;
use App\Filters\FilterById;
use App\Filters\FilterByLocation;
use App\Filters\FilterByRate;
use App\Filters\FilterByRateA;
use App\Filters\FilterByRateB;
use App\Filters\FilterByState;
use App\Filters\FilterByStatus;
use App\Filters\FilterByTowingRateGlobalSearch;
use App\Models\TowingRate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TowingRateService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
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
