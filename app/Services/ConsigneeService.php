<?php

namespace App\Services;

use App\Filters\FilterByConsigneeGlobalSearch;
use App\Filters\FilterByCustomerUser;
use App\Filters\FilterByName;
use App\Filters\FilterByPhone;
use App\Models\Consignee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ConsigneeService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Consignee::query();

        return app(FilterPipelineService::class)->apply($query, [
            FilterByName::class,
            FilterByCustomerUser::class,
            FilterByPhone::class,
            FilterByConsigneeGlobalSearch::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Consignee::find($id);
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
        $consignee = Consignee::findOrNew($id);
        $consignee->fill($data);
        $consignee->save();

        return $consignee;
    }

    public function destroy(int $id): void
    {
        $consignee = Consignee::findOrFail($id);

        $consignee->delete();
    }
}
