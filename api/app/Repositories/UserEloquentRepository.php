<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserEloquentRepository extends RepositoryEloquentBase implements UserRepositoryInterface
{
    public function __construct(private User $user)
    {
        parent::__construct($user);
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
