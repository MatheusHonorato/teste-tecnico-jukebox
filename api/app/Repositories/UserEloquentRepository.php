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
        try {
            return $this->user->create((array) $data);
        } catch (\Exception $e) {
            throw new \App\Exceptions\UserException($e->getMessage());
        }
    }

    public function getById(string $id): User
    {
        try {
            return $this->user->whereId($id)->firstOrFail();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            throw new \App\Exceptions\TaskExceptionNotFound();
        } catch (\Exception) {
            throw new \App\Exceptions\TaskException();
        }
    }

    public function setToken($id, string $token): void
    {
        try {
            $this->getById($id)->updateOrFail(['fcm_token' => $token]);

        } catch (\Exception $e) {
            throw new \App\Exceptions\UserException($e->getMessage());
        }
    }
}
