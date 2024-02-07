<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\CreateUserDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    public function __construct(private User $user)
    {
    }

    public function create(CreateUserDTO $data): User
    {
        return $this->user->create((array) $data);
    }
}
