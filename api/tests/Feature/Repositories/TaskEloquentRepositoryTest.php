<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\DTOs\CreateTaskDTO;
use App\DTOs\CreateUserDTO;
use App\DTOs\UpdateTaskDTO;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskEloquentRepository;
use App\Repositories\UserEloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class TaskEloquentRepositoryTest extends TestCase
{
    private TaskEloquentRepository $taskRepository;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = App::make(UserEloquentRepository::class)->create(new CreateUserDTO(
            ...['id' => (string) fake()->numberBetween(), 'email' => fake()->unique()->safeEmail()]
        ));

        $this->taskRepository = App::make(TaskEloquentRepository::class);
    }

    private function createTask(): Task
    {
        return $this->taskRepository->create(new CreateTaskDTO(...[
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => $this->user->id,
        ]));
    }

    public function test_index(): void
    {
        $tasks = $this->taskRepository->index($this->user->id);
        $this->assertInstanceOf(Paginator::class, $tasks);
    }

    public function test_create(): void
    {
        $task = $this->createTask();
        $this->assertInstanceOf(Task::class, $task);
    }

    public function test_get_by_id(): void
    {
        $task = $this->createTask();
        $this->assertInstanceOf(Task::class, $this->taskRepository->getById($task->id));
    }

    public function test_update(): void
    {
        $task = $this->createTask();

        $this->expectNotToPerformAssertions();

        $this->taskRepository->update($task->id, new UpdateTaskDTO(
            ...[
                'title' => fake()->sentence(),
                'description' => fake()->text(),
                'user_id' => $this->user->id,
            ]
        ));
    }

    public function test_destroy(): void
    {
        $task = $this->createTask();

        $this->expectNotToPerformAssertions();

        $this->taskRepository->destroy($task->id);
    }
}
