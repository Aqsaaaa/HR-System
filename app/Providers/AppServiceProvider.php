<?php

namespace App\Providers;

use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\LeaveRequestRepositoryInterface;
use App\Repositories\Contracts\LeaveTypeRepositoryInterface;
use App\Repositories\Contracts\PayrollComponentRepositoryInterface;
use App\Repositories\Contracts\PayrollRunRepositoryInterface;
use App\Repositories\Contracts\PositionRepositoryInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\AttendanceRepository;
use App\Repositories\BaseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\LeaveRequestRepository;
use App\Repositories\LeaveTypeRepository;
use App\Repositories\PayrollComponentRepository;
use App\Repositories\PayrollRunRepository;
use App\Repositories\PositionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(LeaveTypeRepositoryInterface::class, LeaveTypeRepository::class);
        $this->app->bind(LeaveRequestRepositoryInterface::class, LeaveRequestRepository::class);
        $this->app->bind(PayrollComponentRepositoryInterface::class, PayrollComponentRepository::class);
        $this->app->bind(PayrollRunRepositoryInterface::class, PayrollRunRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
