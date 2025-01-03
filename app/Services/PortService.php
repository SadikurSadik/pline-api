<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByCountry;
use App\Filters\FilterByName;
use App\Filters\FilterByState;
use App\Filters\FilterByStatus;
use App\Models\Port;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class PortService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Port::query();

        return app(FilterPipelineService::class)->apply($query, [
            FilterByName::class,
            FilterByCountry::class,
            FilterByState::class,
            FilterByStatus::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Port::find($id);
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
        $port = Port::findOrNew($id);
        $port->fill($data);
        $port->save();

        return $port;
    }

    public function destroy(int $id): void
    {
        $port = Port::findOrFail($id);

        $port->delete();
    }
}
