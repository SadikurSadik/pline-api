<?php

namespace App\Services;

use App\Enums\VisibilityStatus;
use App\Filters\FilterByAmount;
use App\Filters\FilterByAmountGlobalSearch;
use App\Filters\FilterByFromCountry;
use App\Filters\FilterByFromPort;
use App\Filters\FilterByFromState;
use App\Filters\FilterById;
use App\Filters\FilterByStatus;
use App\Filters\FilterByToCountry;
use App\Filters\FilterByToPort;
use App\Filters\FilterByToState;
use App\Models\ShippingRate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ShippingRateService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = ShippingRate::with([
            'from_country',
            'from_state',
            'from_port',
            'to_country',
            'to_state',
            'to_port',
        ]);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByAmount::class,
            FilterByFromCountry::class,
            FilterByFromState::class,
            FilterByFromPort::class,
            FilterByToCountry::class,
            FilterByToState::class,
            FilterByToPort::class,
            FilterByStatus::class,
            FilterById::class,
            FilterByAmountGlobalSearch::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return ShippingRate::with([
            'from_country',
            'from_state',
            'from_port',
            'to_country',
            'to_state',
            'to_port',
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
        $shippingRate = ShippingRate::findOrNew($id);
        $shippingRate->fill($data);
        $shippingRate->save();

        return $shippingRate;
    }

    public function destroy(int $id): void
    {
        $shippingRate = ShippingRate::findOrFail($id);

        $shippingRate->delete();
    }
}
