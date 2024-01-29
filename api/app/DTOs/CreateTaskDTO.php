<?php

declare(strict_types=1);

namespace App\DTOs;

class CreateTaskDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $user_id
    ) {
    }
}
