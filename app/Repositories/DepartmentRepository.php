<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function getTree(): Collection
    {
        return $this->model->with(['children.children', 'manager'])
            ->root()
            ->orderBy('sort_order')
            ->get();
    }

    public function getRootDepartments(): Collection
    {
        return $this->model->root()->orderBy('name')->get();
    }

    public function getByManager(int $managerId): Collection
    {
        return $this->model->where('manager_id', $managerId)->get();
    }
}
