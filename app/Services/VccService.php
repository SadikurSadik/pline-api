<?php

namespace App\Services;

use App\Filters\FilterByDeclarationNumber;
use App\Filters\FilterByHandedOverTo;
use App\Filters\FilterByReceivedDate;
use App\Filters\FilterByStatus;
use App\Filters\FilterByVehicleRegistrationType;
use App\Models\Vcc;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class VccService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Vcc::with(['vehicle', 'vehicle.customer', 'exit_paper', 'issued_by']);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByReceivedDate::class,
            FilterByDeclarationNumber::class,
            FilterByVehicleRegistrationType::class,
            FilterByHandedOverTo::class,
        ], $filters);
    }
}
