<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\PerformanceReview;
use App\Models\JobPosting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $monthStart = $now->copy()->startOfMonth();

        $data = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('employment_status', 'active')->count(),
            'attendance_today' => Attendance::whereDate('clock_in', $now->toDateString())->count(),
            'pending_leave' => LeaveRequest::where('status', 'pending')->count(),
            'completed_reviews' => PerformanceReview::where('status', 'completed')->count(),
            'open_jobs' => JobPosting::where('status', 'published')->count(),
            'new_hires' => Employee::whereBetween('hire_date', [$monthStart, $now])->count(),
            'pinned_announcements' => Announcement::where('is_pinned', true)->count(),
        ];

        $chart = [
            'leave_by_status' => [
                'pending' => LeaveRequest::where('status', 'pending')->count(),
                'approved' => LeaveRequest::where('status', 'approved')->count(),
                'rejected' => LeaveRequest::where('status', 'rejected')->count(),
            ],
            'employee_by_status' => [
                'active' => Employee::where('employment_status', 'active')->count(),
                'inactive' => Employee::where('employment_status', 'inactive')->count(),
                'terminated' => Employee::where('employment_status', 'terminated')->count(),
                'resigned' => Employee::where('employment_status', 'resigned')->count(),
            ],
        ];

        return Inertia::render('Reports/Index', [
            'data' => $data,
            'chart' => $chart,
        ]);
    }
}
