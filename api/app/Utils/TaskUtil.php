<?php

declare(strict_types=1);

namespace App\Utils;

class TaskUtil
{
    public static function prepareTaskData(array $data, string $userId): array
    {
        return [...$data, 'user_id' => $userId];
    }
}
