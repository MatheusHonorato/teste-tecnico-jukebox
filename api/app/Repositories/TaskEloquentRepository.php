<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;

class TaskEloquentRepository extends RepositoryEloquentBase implements TaskRepositoryInterface
{
    public function __construct(private Task $task)
    {
        parent::__construct($task);
    }
}
