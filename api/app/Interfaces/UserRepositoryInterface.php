<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\DTOs\CreateUserDTO;

interface UserRepositoryInterface
{
    public function create(CreateUserDTO $data): UserInterface;
}
