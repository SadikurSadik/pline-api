<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByAmount;
use App\Filters\FilterByAmountGlobalSearch;
use App\Filters\FilterByFromCountry;
use App\Filters\FilterById;
use App\Filters\FilterByStatus;
use App\Filters\FilterByToCountry;
use App\Models\ExportRate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ExportRateService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = ExportRate::with([
            'from_country',
            'to_country',
        ]);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByAmount::class,
            FilterByFromCountry::class,
            FilterByToCountry::class,
            FilterByStatus::class,
            FilterById::class,
            FilterByAmountGlobalSearch::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return ExportRate::with([
            'from_country',
            'to_country',
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
        $exportRate = ExportRate::findOrNew($id);
        $exportRate->fill($data);
        $exportRate->save();

        return $exportRate;
    }

    public function destroy(int $id): void
    {
        $exportRate = ExportRate::findOrFail($id);

        $exportRate->delete();
    }
}
