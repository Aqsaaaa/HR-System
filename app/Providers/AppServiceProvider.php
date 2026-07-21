<?php

namespace App\Providers;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
