<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\DTOs\CreateTaskDTO;
use App\DTOs\UpdateTaskDTO;
use Illuminate\Contracts\Pagination\Paginator as PaginatorInterface;

interface TaskRepositoryInterface
{
    public function index(string $userId): PaginatorInterface;

    public function create(CreateTaskDTO $data): TaskInterface;

    public function getById(int $id): TaskInterface;

    public function update(int $id, UpdateTaskDTO $data): void;

    public function destroy(int $id): void;
}
