<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;

interface TaskRepositoryInterface
{
    public function index(): Paginator;

    public function create(array $data): Task;

    public function getById(int $id): Task;

    public function update($id, array $data): void;

    public function destroy(int $id): void;
}
