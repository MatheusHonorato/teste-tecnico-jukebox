<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\TaskInterface;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TaskServiceInterface;
use App\Utils\GeneralUtils;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Redis;

class TaskService implements TaskServiceInterface
{
    public const TTL = 3600;

    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function index(string $user_id, string $page): Paginator
    {
        $key = "tasks_{$user_id}_{$page}";

        if (Redis::exists($key)) {
            return GeneralUtils::generatePaginationFromRedis(Redis::get($key));
        }

        $data = $this->taskRepository->index($user_id);

        Redis::setex($key, self::TTL, json_encode($data));

        return $data;
    }

    public function show(int $id, string $user_id): TaskInterface
    {
        $key = "task_{$id}_{$user_id}";

        if (Redis::exists($key)) {
            return unserialize(Redis::get($key));
        }

        $task = $this->taskRepository->getById($id, $user_id);

        Redis::setex($key, self::TTL, serialize($task));

        return $task;
    }
}
