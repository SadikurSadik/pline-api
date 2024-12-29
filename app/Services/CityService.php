<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByCountryOnStateRelation;
use App\Filters\FilterByName;
use App\Filters\FilterByShortCode;
use App\Filters\FilterByStatus;
use App\Models\City;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CityService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = City::query()->with('state.country');

        return app(FilterPipelineService::class)->apply($query, [
            FilterByCountryOnStateRelation::class,
            FilterByStatus::class,
            FilterByName::class,
            FilterByShortCode::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return City::with('state.country')->find($id);
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
        $city = City::findOrNew($id);
        $city->fill($data);
        $city->save();

        return $city;
    }

    public function destroy(int $id): void
    {
        $city = City::findOrFail($id);

        $city->delete();
    }
}
