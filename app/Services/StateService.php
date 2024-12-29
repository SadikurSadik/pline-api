<?php

namespace App\Services;

use App\Filters\FilterByCountry;
use App\Filters\FilterByName;
use App\Filters\FilterByShortCode;
use App\Filters\FilterByStatus;
use App\Models\State;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

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
