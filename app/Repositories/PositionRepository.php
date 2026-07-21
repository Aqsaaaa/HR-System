<?php

namespace App\Repositories;

use App\Models\Position;
use App\Repositories\Contracts\PositionRepositoryInterface;

class PositionRepository extends BaseRepository implements PositionRepositoryInterface
{
    public function __construct(Position $model)
    {
        parent::__construct($model);
    }

    public function getByDepartment(int $departmentId, int $perPage = 15)
    {
        return $this->model->where('department_id', $departmentId)
            ->with('department')
            ->orderBy('title')
            ->paginate($perPage);
    }

    public function getVacant()
    {
        return $this->model->where(function ($q) {
            $q->whereNull('max_headcount')
              ->orWhereColumn('current_headcount', '<', 'max_headcount');
        })->where('is_active', true)->get();
    }
}
