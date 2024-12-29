<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByName;
use App\Filters\FilterByStatus;
use App\Models\TitleType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class TitleTypeService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = TitleType::query();

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByName::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return TitleType::find($id);
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
        $titleType = TitleType::findOrNew($id);
        $titleType->fill($data);
        $titleType->save();

        return $titleType;
    }

    public function destroy(int $id): void
    {
        $titleType = TitleType::findOrFail($id);

        $titleType->delete();
    }
}
