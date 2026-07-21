<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\PayrollRun;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();
        $now = Carbon::now();
        $today = $now->toDateString();

        $data = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('employment_status', 'active')->count(),
            'attendance_today' => Attendance::whereDate('clock_in', $today)->count(),
            'pending_leave' => LeaveRequest::where('status', 'pending')->count(),
            'latest_payroll' => PayrollRun::where('status', 'completed')->latest()->first(),
            'pinned_announcements' => Announcement::where('is_pinned', true)->latest()->take(3)->get(),
            'recent_employees' => Employee::latest()->take(5)->get(),
        ];

        if ($employee) {
            $data['my_attendance'] = Attendance::where('employee_id', $employee->id)
                ->whereDate('clock_in', $today)->first();
            $data['my_leave_balances'] = LeaveBalance::where('employee_id', $employee->id)
                ->with('leaveType')->get();
            $data['my_pending_leave'] = LeaveRequest::where('employee_id', $employee->id)
                ->where('status', 'pending')->count();
        }

        return Inertia::render('Dashboard/Index', [
            'data' => $data,
        ]);
    }
}
