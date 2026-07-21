<?php

namespace App\Services\Leave;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Repositories\Contracts\LeaveRequestRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Support\Facades\DB;

class LeaveRequestService
{
    public function __construct(
        private LeaveRequestRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        $filters['with'] = ['employee.user', 'leaveType', 'approvedByUser'];
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function find(int $id): LeaveRequest
    {
        return $this->repository->findOrFail($id)
            ->load(['employee.user', 'leaveType', 'approvedByUser']);
    }

    public function create(array $data): LeaveRequest
    {
        return DB::transaction(function () use ($data) {
            $data['leave_request_no'] = $data['leave_request_no'] ?? $this->generateRequestNo();
            $data['applied_on'] = now()->format('Y-m-d');
            $data['created_by'] = auth()->id();

            $start = \Carbon\Carbon::parse($data['start_date']);
            $end = \Carbon\Carbon::parse($data['end_date']);
            $data['total_days'] = $start->diffInDays($end) + 1;

            $leaveRequest = $this->repository->create($data);

            $this->updateBalance($data['employee_id'], $data['leave_type_id'], $data['total_days'], 'add_pending');

            $this->auditService->logCreate($leaveRequest, $data, 'leave_request');
            return $leaveRequest;
        });
    }

    public function approve(int $id, array $data = []): LeaveRequest
    {
        return DB::transaction(function () use ($id, $data) {
            $leaveRequest = $this->repository->findOrFail($id);

            if ($leaveRequest->status !== 'pending') {
                throw new \App\Exceptions\BusinessRuleException(
                    'Leave request is already ' . $leaveRequest->status . '.'
                );
            }

            $this->repository->update($leaveRequest, [
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'approval_notes' => $data['notes'] ?? null,
            ]);

            $this->updateBalance(
                $leaveRequest->employee_id,
                $leaveRequest->leave_type_id,
                $leaveRequest->total_days,
                'approve'
            );

            $this->auditService->log('approve', $leaveRequest, $data, 'leave_request');
            return $leaveRequest->fresh()->load(['employee.user', 'leaveType']);
        });
    }

    public function reject(int $id, array $data = []): LeaveRequest
    {
        return DB::transaction(function () use ($id, $data) {
            $leaveRequest = $this->repository->findOrFail($id);

            if ($leaveRequest->status !== 'pending') {
                throw new \App\Exceptions\BusinessRuleException(
                    'Leave request is already ' . $leaveRequest->status . '.'
                );
            }

            $this->repository->update($leaveRequest, [
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'approval_notes' => $data['notes'] ?? null,
            ]);

            $this->updateBalance(
                $leaveRequest->employee_id,
                $leaveRequest->leave_type_id,
                $leaveRequest->total_days,
                'remove_pending'
            );

            $this->auditService->log('reject', $leaveRequest, $data, 'leave_request');
            return $leaveRequest->fresh()->load(['employee.user', 'leaveType']);
        });
    }

    public function cancel(int $id): LeaveRequest
    {
        return DB::transaction(function () use ($id) {
            $leaveRequest = $this->repository->findOrFail($id);

            if (!in_array($leaveRequest->status, ['pending', 'approved'])) {
                throw new \App\Exceptions\BusinessRuleException(
                    'Cannot cancel leave request with status: ' . $leaveRequest->status
                );
            }

            $oldStatus = $leaveRequest->status;
            $this->repository->update($leaveRequest, ['status' => 'cancelled']);

            if ($oldStatus === 'pending') {
                $this->updateBalance($leaveRequest->employee_id, $leaveRequest->leave_type_id, $leaveRequest->total_days, 'remove_pending');
            } elseif ($oldStatus === 'approved') {
                $this->updateBalance($leaveRequest->employee_id, $leaveRequest->leave_type_id, $leaveRequest->total_days, 'subtract_used');
            }

            $this->auditService->log('cancel', $leaveRequest, [], 'leave_request');
            return $leaveRequest->fresh();
        });
    }

    public function getBalances(int $employeeId): array
    {
        $balances = LeaveBalance::with('leaveType')
            ->where('employee_id', $employeeId)
            ->where('year', now()->year)
            ->get();

        return $balances->toArray();
    }

    public function getEmployeeBalances(int $employeeId): array
    {
        return $this->getBalances($employeeId);
    }

    public function getCalendar(int $year, ?int $month = null)
    {
        return $this->repository->getCalendar($year, $month);
    }

    public function getReport(array $filters = [])
    {
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function getByEmployee(int $employeeId, array $filters = [])
    {
        return $this->repository->findByEmployee($employeeId, $filters);
    }

    private function updateBalance(int $employeeId, int $leaveTypeId, int $days, string $action): void
    {
        $balance = LeaveBalance::firstOrCreate(
            [
                'employee_id' => $employeeId,
                'leave_type_id' => $leaveTypeId,
                'year' => now()->year,
            ],
            [
                'total_days' => 0,
                'used_days' => 0,
                'pending_days' => 0,
                'remaining_days' => 0,
                'carried_forward' => 0,
            ]
        );

        match ($action) {
            'add_pending' => $balance->increment('pending_days', $days),
            'remove_pending' => $balance->decrement('pending_days', $days),
            'approve' => function () use ($balance, $days) {
                $balance->decrement('pending_days', $days);
                $balance->increment('used_days', $days);
            },
            'subtract_used' => $balance->decrement('used_days', $days),
            default => null,
        };

        if ($action === 'approve') {
            $balance->decrement('pending_days', $days);
            $balance->increment('used_days', $days);
        }

        $balance->remaining_days = $balance->total_days + $balance->carried_forward - $balance->used_days - $balance->pending_days;
        $balance->save();
    }

    private function generateRequestNo(): string
    {
        $prefix = 'LV-' . now()->format('Ymd') . '-';
        $last = LeaveRequest::where('leave_request_no', 'like', "{$prefix}%")
            ->orderBy('leave_request_no', 'desc')
            ->value('leave_request_no');

        $num = $last ? (int) substr($last, -4) + 1 : 1;
        return $prefix . str_pad((string) $num, 4, '0', STR_PAD_LEFT);
    }
}
