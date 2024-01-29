<?php

declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;

interface TaskServiceInterface
{
    public function index(string $user_id, string $page): Paginator;

    public function show(int $id, string $user_id): TaskInterface;
}
