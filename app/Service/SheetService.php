<?php

namespace App\Service;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByName;
use App\Filters\FilterBySheetGlobalSearch;
use App\Filters\FilterByStatus;
use App\Models\Sheet;
use App\Services\FilterPipelineService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

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
        $sheet = Sheet::findOrNew($id);
        $data['status'] = Arr::get($data, 'status') == VisibilityStatus::ACTIVE->value ?
            VisibilityStatus::ACTIVE->value : VisibilityStatus::INACTIVE->value;
        $sheet->fill($data);
        $sheet->save();

        return $sheet;
    }

    public function destroy($id)
    {
        return Sheet::findOrFail($id)
            ->delete();
    }
}
