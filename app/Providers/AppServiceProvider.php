<?php

namespace App\Providers;

use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\CandidateRepositoryInterface;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\GoalRepositoryInterface;
use App\Repositories\Contracts\JobPostingRepositoryInterface;
use App\Repositories\Contracts\LeaveRequestRepositoryInterface;
use App\Repositories\Contracts\LeaveTypeRepositoryInterface;
use App\Repositories\Contracts\PayrollComponentRepositoryInterface;
use App\Repositories\Contracts\PayrollRunRepositoryInterface;
use App\Repositories\Contracts\PerformanceCycleRepositoryInterface;
use App\Repositories\Contracts\PerformanceReviewRepositoryInterface;
use App\Repositories\Contracts\PositionRepositoryInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\AnnouncementRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CandidateRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\GoalRepository;
use App\Repositories\JobPostingRepository;
use App\Repositories\LeaveRequestRepository;
use App\Repositories\LeaveTypeRepository;
use App\Repositories\PayrollComponentRepository;
use App\Repositories\PayrollRunRepository;
use App\Repositories\PerformanceCycleRepository;
use App\Repositories\PerformanceReviewRepository;
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
        $this->app->bind(JobPostingRepositoryInterface::class, JobPostingRepository::class);
        $this->app->bind(CandidateRepositoryInterface::class, CandidateRepository::class);
        $this->app->bind(PerformanceCycleRepositoryInterface::class, PerformanceCycleRepository::class);
        $this->app->bind(GoalRepositoryInterface::class, GoalRepository::class);
        $this->app->bind(PerformanceReviewRepositoryInterface::class, PerformanceReviewRepository::class);
        $this->app->bind(AnnouncementRepositoryInterface::class, AnnouncementRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
