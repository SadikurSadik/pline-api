<?php

namespace App\Service;

use App\Filters\FilterByName;
use App\Filters\FilterBySheetGlobalSearch;
use App\Filters\FilterByStatus;
use App\Models\Sheet;
use App\Services\FilterPipelineService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SheetService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Sheet::query();

        return app(FilterPipelineService::class)->apply($query, [
            FilterByName::class,
            FilterByStatus::class,
            FilterBySheetGlobalSearch::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Sheet::query()->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->save($data);
    }

    public function update(array $data, int $id)
    {
        return $this->save($data, $id);
    }

    private function save(array $data, ?int $id = null)
    {
        $country = Sheet::findOrNew($id);
        $country->fill($data);
        $country->save();

        return $country;
    }

    public function destroy($id)
    {
        return Sheet::findOrFail($id)
            ->delete();
    }
}
