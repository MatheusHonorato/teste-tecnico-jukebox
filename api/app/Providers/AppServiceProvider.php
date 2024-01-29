<?php

namespace App\Providers;

use App\Repositories\TaskEloquentRepository;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TaskServiceInterface;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, fn () => new TaskEloquentRepository(new Task()));
        $this->app->bind(TaskServiceInterface::class, fn () => new TaskService(new TaskEloquentRepository(new Task())));

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
