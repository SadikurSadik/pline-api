<?php

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;

class FilterPipelineService
{
    public function apply($query, array $filters, array $data = [])
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(array_map(function ($filter) use ($data) {
                return function ($query, $next) use ($filter, $data) {
                    if (is_callable($filter)) {
                        return $filter($query, $next, $data);
                    }

                    return app($filter)->handle($query, $next, $data);
                };
            }, $filters))
            ->then(function ($query) use ($data) {
                $query->orderBy(Arr::get($data, 'order_by_column', 'id'), Arr::get($data, 'order_by', 'desc'));

                if (! empty($data['query_only'])) {
                    return $query;
                }

                $limit = Arr::get($data, 'limit', 20);

                return $limit === -1 ? $query->get() : $query->paginate($limit);
            });
    }
}
