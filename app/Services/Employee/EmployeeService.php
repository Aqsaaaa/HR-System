<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        $filters['with'] = ['department', 'position', 'user', 'reportsTo'];
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function find(int $id): Employee
    {
        return $this->repository->findOrFail($id)->load(['department', 'position', 'user', 'reportsTo', 'subordinates']);
    }

    public function create(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            $data['employee_id'] = $data['employee_id'] ?? $this->generateEmployeeId();
            $data['created_by'] = auth()->id();
            $employee = $this->repository->create($data);
            $this->auditService->logCreate($employee, $data, 'employee');
            return $employee;
        });
    }

    public function update(int $id, array $data): Employee
    {
        return DB::transaction(function () use ($id, $data) {
            $employee = $this->repository->findOrFail($id);
            $old = $employee->toArray();
            $employee = $this->repository->update($employee, $data);
            $this->auditService->logUpdate($employee, $old, $data, 'employee');
            return $employee;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $employee = $this->repository->findOrFail($id);
            $this->repository->delete($employee);
            $this->auditService->logDelete($employee, 'employee');
        });
    }

    public function restore(int $id): Employee
    {
        return DB::transaction(function () use ($id) {
            $employee = $this->repository->restore($id);
            $this->auditService->log('restore', $employee, [], 'employee');
            return $employee;
        });
    }

    public function forceDelete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $employee = $this->repository->findOrFail($id);
            $this->repository->forceDelete($employee);
            $this->auditService->logDelete($employee, 'employee');
        });
    }

    public function generateEmployeeId(): string
    {
        $year = now()->format('y');
        $prefix = "EMP{$year}";
        $last = Employee::where('employee_id', 'like', "{$prefix}%")
            ->orderBy('employee_id', 'desc')
            ->value('employee_id');

        if ($last) {
            $num = (int) substr($last, -5) + 1;
        } else {
            $num = 1;
        }

        return $prefix . str_pad((string) $num, 5, '0', STR_PAD_LEFT);
    }

    public function search(string $query, array $filters = [])
    {
        $filters['with'] = ['department', 'position'];
        return $this->repository->search($query)
            ->with($filters['with'])
            ->paginate($filters['per_page'] ?? config('hris.pagination.default_per_page'));
    }

    public function getByDepartment(int $departmentId)
    {
        return $this->repository->findByDepartment($departmentId);
    }

    public function getByStatus(string $status)
    {
        return $this->repository->getByStatus($status);
    }
}
