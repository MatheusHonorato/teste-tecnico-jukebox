<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\UserInputDTO;

interface UserRepositoryInterface
{
    public function create(UserInputDTO $data): UserInterface;

    public function getById(string $id): UserInterface;

    public function setToken(string $id, string $data): void;
}
