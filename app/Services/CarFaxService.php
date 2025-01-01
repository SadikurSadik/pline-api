<?php

namespace App\Services;

use App\Filters\FilterByCarFaxGlobalSearch;
use App\Filters\FilterByStatus;
use App\Models\CarFax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CarFaxService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = CarFax::with('customer');

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByCarFaxGlobalSearch::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return CarFax::with('customer')->find($id);
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
        $carFax = CarFax::findOrNew($id);
        $carFax->fill($data);
        $carFax->save();

        return $carFax;
    }

    public function destroy(int $id): void
    {
        CarFax::destroy($id);
    }
}
