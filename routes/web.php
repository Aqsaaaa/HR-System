<?php

use App\Http\Controllers\Web\AnnouncementController as WebAnnouncementController;
use App\Http\Controllers\Web\AttendanceController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\LeaveController;
use App\Http\Controllers\Web\PayrollController;
use App\Http\Controllers\Web\PerformanceController as WebPerformanceController;
use App\Http\Controllers\Web\RecruitmentController;
use App\Http\Controllers\Web\ReportController as WebReportController;
use App\Models\Department;
use App\Models\Position;
use App\Services\Employee\EmployeeService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

    Route::get('/forgot-password', function () {
        return Inertia::render('Auth/ForgotPassword');
    })->name('password.request');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/Index');
    })->name('dashboard');

    // Employee routes
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

    // Department routes
    Route::get('/departments', function () {
        return Inertia::render('Departments/Index');
    })->name('departments.index');

    // Position routes
    Route::get('/positions', function () {
        return Inertia::render('Positions/Index');
    })->name('positions.index');

    // Attendance routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    // Leave routes
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/create', [LeaveController::class, 'create'])->name('leave.create');

    // Payroll routes
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/runs/{id}', [PayrollController::class, 'show'])->name('payroll.runs.show');

    // Recruitment routes
    Route::get('/recruitment', [RecruitmentController::class, 'index'])->name('recruitment.index');
    Route::get('/recruitment/{id}', [RecruitmentController::class, 'show'])->name('recruitment.show');
    Route::post('/recruitment/candidates/{id}/stage', [RecruitmentController::class, 'moveStage'])->name('recruitment.candidates.stage');
    Route::post('/recruitment/candidates/{id}/offer', [RecruitmentController::class, 'sendOffer'])->name('recruitment.candidates.offer');

    // Performance routes
    Route::get('/performance', [WebPerformanceController::class, 'index'])->name('performance.index');
    Route::post('/performance', [WebPerformanceController::class, 'store'])->name('performance.store');
    Route::get('/performance/{id}', [WebPerformanceController::class, 'show'])->name('performance.show');
    Route::post('/performance/{id}/launch', [WebPerformanceController::class, 'launchCycle'])->name('performance.launch');

    // Announcement routes
    Route::get('/announcements', [WebAnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [WebAnnouncementController::class, 'store'])->name('announcements.store');
    Route::post('/announcements/{id}/pin', [WebAnnouncementController::class, 'togglePin'])->name('announcements.pin');

    // Settings routes
    Route::get('/settings', function () {
        return Inertia::render('Settings/Index');
    })->name('settings.index');

    // Reports routes
    Route::get('/reports', [WebReportController::class, 'index'])->name('reports.index');

    // Analytics routes
    Route::get('/analytics', function () {
        return Inertia::render('Analytics/Index');
    })->name('analytics.index');

    // Notifications routes
    Route::get('/notifications', function () {
        return Inertia::render('Notifications/Index');
    })->name('notifications.index');
});
