<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeSearch(Builder $query, ?string $search, array $fields = ['name']): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search, $fields) {
            foreach ($fields as $field) {
                $q->orWhere($field, 'like', "%{$search}%");
            }
        });
    }

    public function scopeSort(Builder $query, ?string $sort = 'created_at', ?string $direction = 'desc'): Builder
    {
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';
        $sort = in_array($sort, $this->sortable ?? ['created_at']) ? $sort : 'created_at';

        return $query->orderBy($sort, $direction);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFilterByDateRange(Builder $query, ?string $field, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->whereDate($field, '>=', $from);
        }
        if ($to) {
            $query->whereDate($field, '<=', $to);
        }
        return $query;
    }

    public function scopeWhereInArray(Builder $query, string $field, ?array $values): Builder
    {
        if (!empty($values)) {
            return $query->whereIn($field, $values);
        }
        return $query;
    }
}
