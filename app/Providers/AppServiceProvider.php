<?php

namespace App\Providers;

use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Contracts\PositionRepositoryInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\BaseRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\PositionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
