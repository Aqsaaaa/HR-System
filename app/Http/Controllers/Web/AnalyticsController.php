<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\JobApplication;
use App\Models\LeaveRequest;
use App\Models\PerformanceReview;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $yearStart = $now->copy()->startOfYear();
        $monthStart = $now->copy()->startOfMonth();

        // Monthly headcount trend (current year)
        $headcount = Employee::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $yearStart)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        // Employee by department
        $byDepartment = Employee::select('department_id', DB::raw('COUNT(*) as count'))
            ->groupBy('department_id')
            ->with('department:id,name')
            ->get()
            ->map(fn($e) => ['name' => $e->department?->name ?? 'N/A', 'count' => $e->count]);

        // Attendance rate this month
        $workingDays = max($now->copy()->startOfMonth()->diffInDaysFiltered(function ($date) {
            return $date->dayOfWeek !== Carbon::SUNDAY;
        }, $now), 1);
        $totalAttendance = Attendance::whereBetween('clock_in', [$monthStart, $now])->count();
        $totalEmployees = max(Employee::count(), 1);
        $attendanceRate = round($totalAttendance / ($workingDays * $totalEmployees) * 100, 1);

        // Leave usage by type
        $leaveUsage = LeaveRequest::where('status', 'approved')
            ->select('leave_type_id', DB::raw('SUM(total_days) as total_days'))
            ->groupBy('leave_type_id')
            ->with('leaveType:id,name')
            ->get()
            ->map(fn($l) => ['name' => $l->leaveType?->name ?? 'N/A', 'days' => (int) $l->total_days]);

        // Recruitment pipeline
        $pipeline = [
            'applied' => JobApplication::where('status', 'applied')->count(),
            'screening' => JobApplication::where('status', 'screening')->count(),
            'interview' => JobApplication::where('status', 'interview')->count(),
            'offer' => JobApplication::where('status', 'offer')->count(),
            'hired' => JobApplication::where('status', 'hired')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        // Performance review completion
        $totalReviews = PerformanceReview::count();
        $completedReviews = PerformanceReview::where('status', 'completed')->count();

        return Inertia::render('Analytics/Index', [
            'headcount' => $headcount,
            'byDepartment' => $byDepartment,
            'attendanceRate' => $attendanceRate,
            'leaveUsage' => $leaveUsage,
            'pipeline' => $pipeline,
            'totalReviews' => $totalReviews,
            'completedReviews' => $completedReviews,
        ]);
    }
}
