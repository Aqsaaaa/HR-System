<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\Attendance\AttendanceService;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService
    ) {}

    public function index()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        $today = $employee ? $this->attendanceService->getToday($employee->id) : null;
        $attendances = $employee ? $this->attendanceService->getAll(request()->all()) : [];

        return Inertia::render('Attendance/Index', [
            'today' => $today,
            'attendances' => $attendances,
            'filters' => request()->all(),
        ]);
    }
}
