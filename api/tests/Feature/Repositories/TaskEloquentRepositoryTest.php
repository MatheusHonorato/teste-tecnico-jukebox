<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\DTOs\CreateTaskDTO;
use App\DTOs\UpdateTaskDTO;
use App\Repositories\TaskEloquentRepository;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class TaskEloquentRepositoryTest extends TestCase
{
    public function test_index(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        Auth::login($user);

        $tasks = (new TaskEloquentRepository(new Task()))->index((string) auth()->user()->id);
        $this->assertInstanceOf(Paginator::class, $tasks);
    }

    public function test_create(): void
    {

        $user = User::create([
          'id' => (string) fake()->numberBetween(),
          'email' => fake()->unique()->safeEmail(),
          'password' => 'password',
        ]);

        Auth::login($user);

        $task = (new TaskEloquentRepository(new Task()))->create(new CreateTaskDTO(
            ...[
                'title' => fake()->sentence(),
                'description' => fake()->text(),
                'user_id' => (string) auth()->user()->id]
        ));

        $this->assertInstanceOf(Task::class, $task);
    }

    public function test_getById(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        Auth::login($user);

        $taskRepository = (new TaskEloquentRepository(new Task()));

        $task = (new TaskEloquentRepository(new Task()))->create(new CreateTaskDTO(
            ...[
                'title' => fake()->sentence(),
                'description' => fake()->text(),
                'user_id' => (string) auth()->user()->id]
        ));

        $this->assertInstanceOf(Task::class, $taskRepository->getById($task->id, (string) auth()->user()->id));
    }

    public function test_update(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        Auth::login($user);

        $taskRepository = (new TaskEloquentRepository(new Task()));

        $task = (new TaskEloquentRepository(new Task()))->create(new CreateTaskDTO(
            ...[
                'title' => fake()->sentence(),
                'description' => fake()->text(),
                'user_id' => (string) auth()->user()->id]
        ));

        $this->expectNotToPerformAssertions();

        $taskRepository->update($task->id, new UpdateTaskDTO(
            ...[
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => (string) auth()->user()->id
            ]
        ));
    }

    public function test_destroy(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        Auth::login($user);

        $taskRepository = (new TaskEloquentRepository(new Task()));

        $task = (new TaskEloquentRepository(new Task()))->create(new CreateTaskDTO(
            ...[
                'title' => fake()->sentence(),
                'description' => fake()->text(),
                'user_id' => (string) auth()->user()->id]
        ));

        $this->expectNotToPerformAssertions();

        $taskRepository->destroy($task->id, (string) auth()->user()->id);
    }

}
