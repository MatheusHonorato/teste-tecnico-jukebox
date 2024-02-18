<?php

declare(strict_types=1);

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function create($data);

    public function getById($id);

    public function setToken($id, string $token): void;
}
