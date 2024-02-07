<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\DTOs\CreateUserDTO;
use App\Models\User;
use App\Repositories\UserEloquentRepository;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class UserEloquentRepositoryTest extends TestCase
{
    private UserEloquentRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = App::make(UserEloquentRepository::class);
    }

    public function test_create(): void
    {
        $user = $this->userRepository->create(new CreateUserDTO(
            ...[
                'id' => (string) fake()->numberBetween(),
                'email' => fake()->email(),
            ]
        ));

        $this->assertInstanceOf(User::class, $user);
    }
}
