<?php

declare(strict_types=1);

namespace App\DTOs;

class UserInputDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
    ) {
    }
}
