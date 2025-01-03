<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

abstract class BaseFilter
{
    protected function applyFilter($query, $key, $value, ?callable $callback = null): void
    {
        if (! empty($value)) {
            if ($callback) {
                $callback($query, $value);
            } else {
                $query->where($key, $value);
            }
        }
    }

    /**
     * Apply a basic "where" filter.
     */
    protected function whereFilter(EloquentBuilder|Builder $query, string $key, mixed $value): void
    {
        if (! empty($value)) {
            $query->where($key, $value);
        }
    }

    /**
     * Apply a basic "where" filter.
     */
    protected function whereDateFilter(EloquentBuilder|Builder $query, string $key, mixed $value): void
    {
        if (! empty($value)) {
            $query->whereDate($key, $value);
        }
    }

    /**
     * Apply a "like" filter.
     */
    protected function likeFilter(EloquentBuilder|Builder $query, string $key, ?string $value): void
    {
        if (! empty($value)) {
            $query->where($key, 'like', "%{$value}%");
        }
    }

    /**
     * Apply a "where between" filter.
     */
    protected function whereBetweenFilter(EloquentBuilder|Builder $query, string $key, ?array $range): void
    {
        if (is_array($range) && count($range) === 2) {
            $query->whereBetween($key, $range);
        }
    }

    /**
     * Apply an OR filter for multiple fields.
     */
    protected function orFilter(EloquentBuilder|Builder $query, array $fields, ?string $value): void
    {
        if (! empty($value)) {
            $query->where(function ($query) use ($fields, $value) {
                foreach ($fields as $field) {
                    if (is_callable($field)) {
                        $field($query, $value);
                    } else {
                        $query->orWhere($field, 'like', "%{$value}%");
                    }
                }
            });
        }
    }
}
