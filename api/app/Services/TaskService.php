<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\TaskInterface;
use App\Contracts\TaskRepositoryInterface;
use App\Contracts\TaskServiceInterface;
use App\Utils\GeneralUtils;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Redis;

class TaskService implements TaskServiceInterface
{
    public const TTL = 60;

    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function index(string $user_id, string $page): Paginator
    {
        $key = "tasks_{$user_id}_{$page}";

        if (Redis::exists($key)) {
            return GeneralUtils::generatePaginationFromRedis(Redis::get($key));
        }

        $tasks = $this->taskRepository->index($user_id);

        Redis::setex($key, self::TTL, json_encode($tasks));

        return $tasks;
    }

    public function show(int $id): TaskInterface
    {
        $key = "task_{$id}";

        if (Redis::exists($key)) {
            return unserialize(Redis::get($key));
        }

        $task = $this->taskRepository->getById($id);

        Redis::setex($key, self::TTL, serialize($task));

        return $task;
    }
}
