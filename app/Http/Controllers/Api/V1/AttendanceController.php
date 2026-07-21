<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Attendance\ClockInRequest;
use App\Http\Requests\Attendance\ClockOutRequest;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Http\Resources\Attendance\HolidayResource;
use App\Models\Employee;
use App\Models\Holiday;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends BaseController
{
    public function __construct(
        private AttendanceService $attendanceService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $attendances = $this->attendanceService->getAll($request->all());
        return $this->paginated($attendances, AttendanceResource::class);
    }

    public function store(StoreAttendanceRequest $request): JsonResponse
    {
        $attendance = $this->attendanceService->create($request->validated());
        return $this->created(new AttendanceResource($attendance), 'Attendance created');
    }

    public function show(int $id): JsonResponse
    {
        $attendance = $this->attendanceService->find($id);
        return $this->success(new AttendanceResource($attendance));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $attendance = $this->attendanceService->update($id, $request->all());
        return $this->success(new AttendanceResource($attendance), 'Attendance updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->attendanceService->delete($id);
        return $this->noContent();
    }

    public function clockIn(ClockInRequest $request): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $attendance = $this->attendanceService->clockIn($employee->id, $request->validated());
        return $this->success(new AttendanceResource($attendance), 'Clocked in successfully');
    }

    public function clockOut(ClockOutRequest $request): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $attendance = $this->attendanceService->clockOut($employee->id, $request->validated());
        return $this->success(new AttendanceResource($attendance), 'Clocked out successfully');
    }

    public function today(): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $attendance = $this->attendanceService->getToday($employee->id);
        return $this->success($attendance ? new AttendanceResource($attendance) : null);
    }

    public function summary(Request $request): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $summary = $this->attendanceService->getSummary(
            $employee->id,
            $request->get('year'),
            $request->get('month')
        );
        return $this->success($summary);
    }

    public function report(Request $request): JsonResponse
    {
        $report = $this->attendanceService->getReport($request->all());
        return $this->paginated($report, AttendanceResource::class);
    }

    public function import(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx']);
        return $this->success([], 'Import started');
    }

    public function mySchedule(): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $schedules = $employee->schedules()->where('is_active', true)->get();
        return $this->success($schedules);
    }

    public function holidays(Request $request): JsonResponse
    {
        $query = Holiday::query();
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $holidays = $query->orderBy('date')->get();
        return $this->success(HolidayResource::collection($holidays));
    }
}
