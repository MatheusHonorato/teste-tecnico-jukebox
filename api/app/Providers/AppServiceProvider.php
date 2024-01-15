<?php

namespace App\Providers;

use App\Http\Repositories\TaskRepository;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, fn () => new TaskRepository(new Task()));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
