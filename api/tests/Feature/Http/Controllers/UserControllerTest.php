<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\DTOs\CreateUserDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private User $user;

    public function test_set_token(): void
    {
        $this->user = app(UserRepositoryInterface::class)->create(new CreateUserDTO(
            ...['id' => (string) fake()->numberBetween(), 'email' => fake()->unique()->safeEmail()]
        ));

        $response = $this->post(route('users.token', $this->user->id), [
            'fcm_token' => (string) fake()->numberBetween(),
        ]);

        $response->assertNoContent();
    }
}
