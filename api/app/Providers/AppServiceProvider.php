<?php

namespace App\Providers;

use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TaskServiceInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskEloquentRepository;
use App\Repositories\UserEloquentRepository;
use App\Services\TaskService;
use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(UserRepositoryInterface::class, fn () => new UserEloquentRepository(new User()));
        $this->app->bind(TaskRepositoryInterface::class, fn () => new TaskEloquentRepository(new Task()));
        $this->app->bind(TaskServiceInterface::class, fn () => new TaskService(new TaskEloquentRepository(new Task())));
        $this->app->bind(FirebaseAuth::class, fn () => Firebase::auth());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
