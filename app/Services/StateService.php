<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByCountry;
use App\Filters\FilterByName;
use App\Filters\FilterByShortCode;
use App\Filters\FilterByStatus;
use App\Models\State;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class StateService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = State::query()->with('country');

        return app(FilterPipelineService::class)->apply($query, [
            FilterByName::class,
            FilterByCountry::class,
            FilterByShortCode::class,
            FilterByStatus::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return State::with('country')->find($id);
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
        $state = State::findOrNew($id);
        $state->fill($data);
        $state->save();

        return $state;
    }

    public function destroy(int $id): void
    {
        $state = State::findOrFail($id);

        $state->delete();
    }
}
