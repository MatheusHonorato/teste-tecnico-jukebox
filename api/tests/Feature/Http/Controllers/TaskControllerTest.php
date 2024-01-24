<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public function test_index(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $token = User::find($user->id)->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get(route('tasks.index'));

        $response->assertOk();
    }

    public function test_store(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $token = User::find($user->id)->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post(route('tasks.store'), [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
        ]);

        $response->assertCreated();
    }

    public function test_show(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $task = Task::create([
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => $user->id,
        ]);

        $token = User::find($user->id)->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get(route('tasks.show', $task->id));

        $response->assertOk();
    }

    public function test_update(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $task = Task::create([
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => $user->id,
        ]);

        $token = User::find($user->id)->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->put(route('tasks.update', $task->id), [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
        ]);

        $response->assertNoContent();
    }

    public function test_destroy(): void
    {
        $user = User::create([
            'id' => (string) fake()->numberBetween(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $task = Task::create([
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => $user->id,
        ]);

        $token = User::find($user->id)->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->delete(route('tasks.destroy', $task->id));

        $response->assertNoContent();
    }
}
