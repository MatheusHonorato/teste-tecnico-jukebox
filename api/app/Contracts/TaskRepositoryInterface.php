<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\TaskInputDTO;
use Illuminate\Contracts\Pagination\Paginator as PaginatorInterface;

interface TaskRepositoryInterface
{
    public function index(string $userId): PaginatorInterface;

    public function create(TaskInputDTO $data): TaskInterface;

    public function getById(int $id): TaskInterface;

    public function update(int $id, TaskInputDTO $data): void;

    public function destroy(int $id): void;
}
