<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Health check
    Route::get('health', fn() => response()->json(['status' => 'ok', 'timestamp' => now()]));

    // Authentication
    Route::prefix('auth')->group(function () {
        Route::post('login', [App\Http\Controllers\Api\V1\AuthController::class, 'login']);
        Route::post('forgot-password', [App\Http\Controllers\Api\V1\AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [App\Http\Controllers\Api\V1\AuthController::class, 'resetPassword']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
            Route::post('logout/all', [App\Http\Controllers\Api\V1\AuthController::class, 'logoutAll']);
            Route::get('profile', [App\Http\Controllers\Api\V1\AuthController::class, 'profile']);
            Route::put('profile', [App\Http\Controllers\Api\V1\AuthController::class, 'updateProfile']);
            Route::put('password', [App\Http\Controllers\Api\V1\AuthController::class, 'changePassword']);
            Route::post('2fa/enable', [App\Http\Controllers\Api\V1\AuthController::class, 'enable2fa']);
            Route::post('2fa/disable', [App\Http\Controllers\Api\V1\AuthController::class, 'disable2fa']);
            Route::post('2fa/verify', [App\Http\Controllers\Api\V1\AuthController::class, 'verify2fa']);
            Route::get('sessions', [App\Http\Controllers\Api\V1\AuthController::class, 'sessions']);
            Route::delete('sessions/{id}', [App\Http\Controllers\Api\V1\AuthController::class, 'terminateSession']);
        });
    });

    // Protected API routes
    Route::middleware('auth:sanctum')->group(function () {

        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Api\V1\DashboardController::class, 'index']);
        Route::get('dashboard/metrics', [App\Http\Controllers\Api\V1\DashboardController::class, 'metrics']);

        // Employee
        Route::get('employees/export', [App\Http\Controllers\Api\V1\EmployeeController::class, 'export']);
        Route::post('employees/import', [App\Http\Controllers\Api\V1\EmployeeController::class, 'import']);
        Route::get('employees/template', [App\Http\Controllers\Api\V1\EmployeeController::class, 'template']);
        Route::get('employees/{id}/documents', [App\Http\Controllers\Api\V1\EmployeeController::class, 'documents']);
        Route::post('employees/{id}/documents', [App\Http\Controllers\Api\V1\EmployeeController::class, 'uploadDocument']);
        Route::delete('employees/{id}/documents/{docId}', [App\Http\Controllers\Api\V1\EmployeeController::class, 'deleteDocument']);
        Route::get('employees/{id}/history', [App\Http\Controllers\Api\V1\EmployeeController::class, 'history']);
        Route::get('employees/{id}/timeline', [App\Http\Controllers\Api\V1\EmployeeController::class, 'timeline']);
        Route::post('employees/{id}/restore', [App\Http\Controllers\Api\V1\EmployeeController::class, 'restore']);
        Route::delete('employees/{id}/force', [App\Http\Controllers\Api\V1\EmployeeController::class, 'forceDelete']);
        Route::apiResource('employees', App\Http\Controllers\Api\V1\EmployeeController::class);

        // Department
        Route::get('departments/tree', [App\Http\Controllers\Api\V1\DepartmentController::class, 'tree']);
        Route::apiResource('departments', App\Http\Controllers\Api\V1\DepartmentController::class);

        // Position
        Route::apiResource('positions', App\Http\Controllers\Api\V1\PositionController::class);

        // Attendance
        Route::post('attendance/clock-in', [App\Http\Controllers\Api\V1\AttendanceController::class, 'clockIn']);
        Route::post('attendance/clock-out', [App\Http\Controllers\Api\V1\AttendanceController::class, 'clockOut']);
        Route::get('attendance/today', [App\Http\Controllers\Api\V1\AttendanceController::class, 'today']);
        Route::get('attendance/summary', [App\Http\Controllers\Api\V1\AttendanceController::class, 'summary']);
        Route::get('attendance/report', [App\Http\Controllers\Api\V1\AttendanceController::class, 'report']);
        Route::post('attendance/import', [App\Http\Controllers\Api\V1\AttendanceController::class, 'import']);
        Route::get('attendance/my-schedule', [App\Http\Controllers\Api\V1\AttendanceController::class, 'mySchedule']);
        Route::get('attendance/holidays', [App\Http\Controllers\Api\V1\AttendanceController::class, 'holidays']);
        Route::apiResource('attendance', App\Http\Controllers\Api\V1\AttendanceController::class);

        // Leave
        Route::post('leave-requests/{id}/approve', [App\Http\Controllers\Api\V1\LeaveRequestController::class, 'approve']);
        Route::post('leave-requests/{id}/reject', [App\Http\Controllers\Api\V1\LeaveRequestController::class, 'reject']);
        Route::get('leave-balances', [App\Http\Controllers\Api\V1\LeaveRequestController::class, 'balances']);
        Route::get('leave-balances/{employeeId}', [App\Http\Controllers\Api\V1\LeaveRequestController::class, 'employeeBalances']);
        Route::get('leave/calendar', [App\Http\Controllers\Api\V1\LeaveRequestController::class, 'calendar']);
        Route::get('leave/report', [App\Http\Controllers\Api\V1\LeaveRequestController::class, 'report']);
        Route::apiResource('leave-types', App\Http\Controllers\Api\V1\LeaveTypeController::class);
        Route::apiResource('leave-requests', App\Http\Controllers\Api\V1\LeaveRequestController::class);

        // Payroll
        Route::post('payroll/runs/{id}/process', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'process']);
        Route::post('payroll/runs/{id}/complete', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'complete']);
        Route::post('payroll/runs/{id}/cancel', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'cancel']);
        Route::get('payroll/runs/{id}/preview', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'preview']);
        Route::get('payroll/runs/{id}/payslips', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'payslips']);
        Route::get('payroll/payslips', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'myPayslips']);
        Route::get('payroll/payslips/{id}', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'payslipDetail']);
        Route::get('payroll/payslips/{id}/download', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'downloadPayslip']);
        Route::get('payroll/report', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'report']);
        Route::post('payroll/adjustments', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'createAdjustment']);
        Route::get('payroll/export/journal', [App\Http\Controllers\Api\V1\PayrollRunController::class, 'exportJournal']);
        Route::apiResource('payroll/components', App\Http\Controllers\Api\V1\PayrollComponentController::class);
        Route::apiResource('payroll/runs', App\Http\Controllers\Api\V1\PayrollRunController::class);

        // Recruitment
        Route::post('recruitment/candidates/{id}/stage', [App\Http\Controllers\Api\V1\RecruitmentController::class, 'moveStage']);
        Route::post('recruitment/candidates/{id}/offer', [App\Http\Controllers\Api\V1\RecruitmentController::class, 'sendOffer']);
        Route::get('recruitment/pipeline', [App\Http\Controllers\Api\V1\RecruitmentController::class, 'pipeline']);
        Route::apiResource('recruitment/jobs', App\Http\Controllers\Api\V1\RecruitmentController::class);
        Route::apiResource('recruitment/candidates', App\Http\Controllers\Api\V1\RecruitmentController::class);

        // Performance
        Route::post('performance/cycles/{id}/launch', [App\Http\Controllers\Api\V1\PerformanceController::class, 'launchCycle']);
        Route::post('performance/reviews/{id}/submit', [App\Http\Controllers\Api\V1\PerformanceController::class, 'submitReview']);
        Route::apiResource('performance/cycles', App\Http\Controllers\Api\V1\PerformanceController::class);
        Route::apiResource('performance/reviews', App\Http\Controllers\Api\V1\PerformanceController::class);
        Route::apiResource('performance/goals', App\Http\Controllers\Api\V1\GoalController::class);

        // Announcement
        Route::post('announcements/{id}/pin', [App\Http\Controllers\Api\V1\AnnouncementController::class, 'togglePin']);
        Route::post('announcements/{id}/read', [App\Http\Controllers\Api\V1\AnnouncementController::class, 'markAsRead']);
        Route::apiResource('announcements', App\Http\Controllers\Api\V1\AnnouncementController::class);

        // Notification
        Route::get('notifications/unread-count', [App\Http\Controllers\Api\V1\NotificationController::class, 'unreadCount']);
        Route::post('notifications/{id}/read', [App\Http\Controllers\Api\V1\NotificationController::class, 'markAsRead']);
        Route::post('notifications/read-all', [App\Http\Controllers\Api\V1\NotificationController::class, 'markAllAsRead']);
        Route::put('notifications/preferences', [App\Http\Controllers\Api\V1\NotificationController::class, 'updatePreferences']);
        Route::apiResource('notifications', App\Http\Controllers\Api\V1\NotificationController::class);

        // Settings
        Route::get('settings/company', [App\Http\Controllers\Api\V1\SettingController::class, 'company']);
        Route::put('settings/company', [App\Http\Controllers\Api\V1\SettingController::class, 'updateCompany']);
        Route::get('settings/general', [App\Http\Controllers\Api\V1\SettingController::class, 'general']);
        Route::put('settings/general', [App\Http\Controllers\Api\V1\SettingController::class, 'updateGeneral']);
        Route::get('roles/{id}/permissions', [App\Http\Controllers\Api\V1\RoleController::class, 'permissions']);
        Route::put('roles/{id}/permissions', [App\Http\Controllers\Api\V1\RoleController::class, 'updatePermissions']);
        Route::put('users/{id}/roles', [App\Http\Controllers\Api\V1\RoleController::class, 'assignRoles']);
        Route::apiResource('roles', App\Http\Controllers\Api\V1\RoleController::class);
        Route::get('permissions', [App\Http\Controllers\Api\V1\PermissionController::class, 'index']);

        // Audit Log
        Route::get('audit-logs/export', [App\Http\Controllers\Api\V1\AuditLogController::class, 'export']);
        Route::apiResource('audit-logs', App\Http\Controllers\Api\V1\AuditLogController::class);

        // Report
        Route::post('reports/generate', [App\Http\Controllers\Api\V1\ReportController::class, 'generate']);
        Route::get('reports/generated', [App\Http\Controllers\Api\V1\ReportController::class, 'generated']);
        Route::get('reports/generated/{id}', [App\Http\Controllers\Api\V1\ReportController::class, 'download']);
        Route::delete('reports/generated/{id}', [App\Http\Controllers\Api\V1\ReportController::class, 'deleteGenerated']);
        Route::apiResource('reports/schedules', App\Http\Controllers\Api\V1\ReportScheduleController::class);
        Route::apiResource('reports', App\Http\Controllers\Api\V1\ReportController::class);

        // Analytics
        Route::get('analytics/headcount', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'headcount']);
        Route::get('analytics/turnover', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'turnover']);
        Route::get('analytics/attendance', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'attendance']);
        Route::get('analytics/leave', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'leave']);
        Route::get('analytics/payroll', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'payroll']);
        Route::get('analytics/recruitment', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'recruitment']);
        Route::get('analytics/performance', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'performance']);
        Route::get('analytics/overview', [App\Http\Controllers\Api\V1\AnalyticsController::class, 'overview']);
    });
});
