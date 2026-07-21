<?php

namespace App\Services\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function __construct(
        private AttendanceRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        $filters['with'] = ['employee.user', 'employee.department', 'employee.position'];
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function find(int $id): Attendance
    {
        return $this->repository->findOrFail($id)
            ->load(['employee.user', 'employee.department', 'employee.position']);
    }

    public function clockIn(int $employeeId, array $data): Attendance
    {
        return DB::transaction(function () use ($employeeId, $data) {
            $existing = $this->repository->findByEmployeeAndDate(
                $employeeId, now()->format('Y-m-d')
            );

            if ($existing && $existing->clock_in) {
                throw new \App\Exceptions\BusinessRuleException('Already clocked in today.');
            }

            $attendance = $this->repository->create([
                'employee_id' => $employeeId,
                'date' => now()->format('Y-m-d'),
                'clock_in' => now(),
                'status' => 'present',
                'type' => $data['type'] ?? 'office',
                'latitude_in' => $data['latitude'] ?? null,
                'longitude_in' => $data['longitude'] ?? null,
                'ip_address_in' => request()->ip(),
                'device_in' => $data['device'] ?? null,
                'photo_in' => $data['photo'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $this->auditService->logCreate($attendance, $data, 'attendance');
            return $attendance;
        });
    }

    public function clockOut(int $employeeId, array $data): Attendance
    {
        return DB::transaction(function () use ($employeeId, $data) {
            $attendance = $this->repository->findByEmployeeAndDate(
                $employeeId, now()->format('Y-m-d')
            );

            if (!$attendance || !$attendance->clock_in) {
                throw new \App\Exceptions\BusinessRuleException('Not clocked in today.');
            }

            if ($attendance->clock_out) {
                throw new \App\Exceptions\BusinessRuleException('Already clocked out today.');
            }

            $clockIn = \Carbon\Carbon::parse($attendance->clock_in);
            $clockOut = now();
            $totalHours = $clockIn->diffInHours($clockOut);

            $this->repository->update($attendance, [
                'clock_out' => $clockOut,
                'latitude_out' => $data['latitude'] ?? null,
                'longitude_out' => $data['longitude'] ?? null,
                'ip_address_out' => request()->ip(),
                'device_out' => $data['device'] ?? null,
                'photo_out' => $data['photo'] ?? null,
                'notes' => $data['notes'] ?? null,
                'total_hours' => round($totalHours, 2),
            ]);

            $this->auditService->logUpdate($attendance, [], $data, 'attendance');
            return $attendance->fresh();
        });
    }

    public function getToday(int $employeeId): ?Attendance
    {
        return $this->repository->getTodayByEmployee($employeeId);
    }

    public function getSummary(int $employeeId, ?int $year = null, ?int $month = null): array
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;

        $records = $this->repository->getMonthlySummary($employeeId, $year, $month);

        $totalHours = $records->sum('total_hours');
        $overtimeHours = $records->sum('overtime_hours');
        $present = $records->where('status', 'present')->count();
        $late = $records->where('status', 'late')->count();
        $absent = $records->where('status', 'absent')->count();
        $halfDay = $records->where('status', 'half_day')->count();

        return [
            'year' => $year,
            'month' => $month,
            'total_days' => $records->count(),
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'half_day' => $halfDay,
            'total_hours' => round($totalHours, 2),
            'overtime_hours' => round($overtimeHours, 2),
            'records' => $records,
        ];
    }

    public function getReport(array $filters = [])
    {
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function create(array $data): Attendance
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $attendance = $this->repository->create($data);
            $this->auditService->logCreate($attendance, $data, 'attendance');
            return $attendance;
        });
    }

    public function update(int $id, array $data): Attendance
    {
        return DB::transaction(function () use ($id, $data) {
            $attendance = $this->repository->findOrFail($id);
            $old = $attendance->toArray();
            $attendance = $this->repository->update($attendance, $data);
            $this->auditService->logUpdate($attendance, $old, $data, 'attendance');
            return $attendance;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $attendance = $this->repository->findOrFail($id);
            $this->repository->delete($attendance);
            $this->auditService->logDelete($attendance, 'attendance');
        });
    }

    public function approve(int $id): Attendance
    {
        return DB::transaction(function () use ($id) {
            $attendance = $this->repository->findOrFail($id);
            $this->repository->update($attendance, [
                'is_approved' => true,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            return $attendance->fresh();
        });
    }
}
