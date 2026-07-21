<?php

use App\Http\Controllers\Web\AttendanceController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\LeaveController;
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
    Route::get('/payroll', function () {
        return Inertia::render('Payroll/Index');
    })->name('payroll.index');

    // Recruitment routes
    Route::get('/recruitment', function () {
        return Inertia::render('Recruitment/Index');
    })->name('recruitment.index');

    // Performance routes
    Route::get('/performance', function () {
        return Inertia::render('Performance/Index');
    })->name('performance.index');

    // Announcement routes
    Route::get('/announcements', function () {
        return Inertia::render('Announcement/Index');
    })->name('announcements.index');

    // Settings routes
    Route::get('/settings', function () {
        return Inertia::render('Settings/Index');
    })->name('settings.index');

    // Reports routes
    Route::get('/reports', function () {
        return Inertia::render('Reports/Index');
    })->name('reports.index');

    // Analytics routes
    Route::get('/analytics', function () {
        return Inertia::render('Analytics/Index');
    })->name('analytics.index');

    // Notifications routes
    Route::get('/notifications', function () {
        return Inertia::render('Notifications/Index');
    })->name('notifications.index');
});
