<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\DTOs\CreateUserDTO;

interface UserRepositoryInterface
{
    public function create(CreateUserDTO $data): UserInterface;

    public function getById(string $id): UserInterface;

    public function setToken(string $id, string $data): void;
}
