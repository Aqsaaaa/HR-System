<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function findByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }

    public function findByDepartment(int $departmentId)
    {
        return $this->model->where('department_id', $departmentId)->get();
    }

    public function findByPosition(int $positionId)
    {
        return $this->model->where('position_id', $positionId)->get();
    }

    public function getActive()
    {
        return $this->model->where('employment_status', 'active')->get();
    }

    public function getByStatus(string $status)
    {
        return $this->model->where('employment_status', $status)->get();
    }

    public function search(string $query)
    {
        return $this->model->where(function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%")
              ->orWhere('last_name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%")
              ->orWhere('employee_id', 'like', "%{$query}%")
              ->orWhere('phone', 'like', "%{$query}%");
        });
    }

    public function getBySupervisor(int $supervisorId): Collection
    {
        return $this->model->where('report_to', $supervisorId)->get();
    }
}
