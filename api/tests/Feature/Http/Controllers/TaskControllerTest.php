<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\DTOs\CreateTaskDTO;
use App\DTOs\CreateUserDTO;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private TaskRepositoryInterface $taskRepository;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = app(UserRepositoryInterface::class)->create(new CreateUserDTO(
            ...['id' => (string) fake()->numberBetween(), 'email' => fake()->unique()->safeEmail()]
        ));

        $this->taskRepository = app(TaskRepositoryInterface::class);
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.index'));

        $response->assertOk();
    }

    public function test_store(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
        ]);

        $response->assertCreated();
    }

    public function test_show(): void
    {
        $task = $this->taskRepository->create(new CreateTaskDTO(...[
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => $this->user->id,
        ]));

        $response = $this->actingAs($this->user)->get(route('tasks.show', $task->id));

        $response->assertOk();
    }

    public function test_update(): void
    {
        $task = $this->taskRepository->create(new CreateTaskDTO(...[
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => $this->user->id,
        ]));

        $response = $this->actingAs($this->user)->put(route('tasks.update', $task->id), [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
        ]);

        $response->assertNoContent();
    }

    public function test_destroy(): void
    {
        $task = $this->taskRepository->create(new CreateTaskDTO(...[
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => $this->user->id,
        ]));

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task->id));

        $response->assertNoContent();
    }
}
