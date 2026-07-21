<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRepository extends BaseRepository implements AttendanceRepositoryInterface
{
    public function __construct(Attendance $model)
    {
        parent::__construct($model);
    }

    public function findByEmployeeAndDate(int $employeeId, string $date)
    {
        return $this->model->where('employee_id', $employeeId)
            ->where('date', $date)
            ->first();
    }

    public function getTodayByEmployee(int $employeeId)
    {
        return $this->model->where('employee_id', $employeeId)
            ->where('date', now()->format('Y-m-d'))
            ->first();
    }

    public function getByEmployeeAndPeriod(int $employeeId, string $start, string $end)
    {
        return $this->model->where('employee_id', $employeeId)
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getByDate(string $date)
    {
        return $this->model->where('date', $date)
            ->with('employee.department')
            ->get();
    }

    public function getByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->with('employee')
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getMonthlySummary(int $employeeId, int $year, int $month)
    {
        $start = "{$year}-{$month}-01";
        $end = date('Y-m-t', strtotime($start));

        return $this->model->where('employee_id', $employeeId)
            ->whereBetween('date', [$start, $end])
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getPendingApproval()
    {
        return $this->model->where('is_approved', false)
            ->whereNotNull('clock_out')
            ->with('employee')
            ->orderBy('date', 'desc')
            ->get();
    }
}
