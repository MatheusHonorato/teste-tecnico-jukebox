<?php

declare(strict_types=1);

namespace App\DTOs;

class CreateUserDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
    ) {
    }
}
