<?php

namespace App\Services;

use App\Filters\FilterByName;
use App\Filters\FilterByShortCode;
use App\Filters\FilterByStatus;
use App\Models\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CountryService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Country::query();

        return app(FilterPipelineService::class)->apply($query, [
            FilterByName::class,
            FilterByStatus::class,
            FilterByShortCode::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Country::find($id);
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
        $country = Country::findOrNew($id);
        $country->fill($data);
        $country->save();

        return $country;
    }

    public function destroy(int $id): void
    {
        $country = Country::findOrFail($id);

        $country->delete();
    }
}
