<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;

interface TaskServiceInterface
{
    public function index(string $user_id, string $page): Paginator;

    public function show(int $id): ?Task;
}
