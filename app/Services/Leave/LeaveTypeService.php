<?php

namespace App\Services\Leave;

use App\Models\LeaveType;
use App\Repositories\Contracts\LeaveTypeRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Support\Facades\DB;

class LeaveTypeService
{
    public function __construct(
        private LeaveTypeRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function getActive()
    {
        return $this->repository->getActive();
    }

    public function find(int $id): LeaveType
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): LeaveType
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $leaveType = $this->repository->create($data);
            $this->auditService->logCreate($leaveType, $data, 'leave_type');
            return $leaveType;
        });
    }

    public function update(int $id, array $data): LeaveType
    {
        return DB::transaction(function () use ($id, $data) {
            $leaveType = $this->repository->findOrFail($id);
            $old = $leaveType->toArray();
            $leaveType = $this->repository->update($leaveType, $data);
            $this->auditService->logUpdate($leaveType, $old, $data, 'leave_type');
            return $leaveType;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $leaveType = $this->repository->findOrFail($id);

            if ($leaveType->leaveRequests()->count() > 0) {
                throw new \App\Exceptions\BusinessRuleException(
                    'Cannot delete leave type with existing requests.'
                );
            }

            $this->repository->delete($leaveType);
            $this->auditService->logDelete($leaveType, 'leave_type');
        });
    }
}
