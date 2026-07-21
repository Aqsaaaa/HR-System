<?php

namespace App\Repositories;

use App\Models\LeaveRequest;
use App\Repositories\Contracts\LeaveRequestRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class LeaveRequestRepository extends BaseRepository implements LeaveRequestRepositoryInterface
{
    public function __construct(LeaveRequest $model)
    {
        parent::__construct($model);
    }

    public function findByEmployee(int $employeeId, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->where('employee_id', $employeeId)
            ->with(['leaveType', 'employee']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['year'])) {
            $query->whereYear('start_date', $filters['year']);
        }

        $perPage = $filters['per_page'] ?? 15;
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getByStatus(string $status): Collection
    {
        return $this->model->where('status', $status)
            ->with(['employee', 'leaveType'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPending(): Collection
    {
        return $this->model->where('status', 'pending')
            ->with(['employee', 'leaveType'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getByDateRange(string $start, string $end): Collection
    {
        return $this->model->whereBetween('start_date', [$start, $end])
            ->orWhereBetween('end_date', [$start, $end])
            ->with(['employee', 'leaveType'])
            ->orderBy('start_date')
            ->get();
    }

    public function getByEmployeeAndYear(int $employeeId, int $year): Collection
    {
        return $this->model->where('employee_id', $employeeId)
            ->whereYear('start_date', $year)
            ->with('leaveType')
            ->get();
    }

    public function getCalendar(int $year, ?int $month = null): Collection
    {
        $query = $this->model->whereIn('status', ['approved', 'pending'])
            ->with(['employee', 'leaveType']);

        if ($month) {
            $query->whereYear('start_date', $year)
                ->whereMonth('start_date', $month);
        } else {
            $query->whereYear('start_date', $year);
        }

        return $query->orderBy('start_date')->get();
    }
}
