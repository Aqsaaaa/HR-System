<?php

namespace App\Repositories;

use App\Models\LeaveType;
use App\Repositories\Contracts\LeaveTypeRepositoryInterface;

class LeaveTypeRepository extends BaseRepository implements LeaveTypeRepositoryInterface
{
    public function __construct(LeaveType $model)
    {
        parent::__construct($model);
    }

    public function getActive()
    {
        return $this->model->where('is_active', true)->orderBy('name')->get();
    }

    public function findByCode(string $code)
    {
        return $this->model->where('code', $code)->first();
    }
}
