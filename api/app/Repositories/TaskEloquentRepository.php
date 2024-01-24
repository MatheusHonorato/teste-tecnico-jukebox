<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\CreateTaskDTO;
use App\DTOs\UpdateTaskDTO;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;

class TaskEloquentRepository implements TaskRepositoryInterface
{
    public function __construct(private Task $task)
    {
    }

    public function index(string $userId): Paginator
    {
        return $this->task->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function create(CreateTaskDTO $data): Task
    {
        try {
            return $this->task->create((array) $data);

        } catch (\Exception $e) {
            throw new \App\Exceptions\TaskException($e->getMessage());
        }
    }

    public function getById(int $id, string $userId): Task
    {
        try {

            return $this->task->where('id', $id)->where('user_id', $userId)->firstOrFail();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            throw new \App\Exceptions\TaskExceptionNotFound();
        } catch (\Exception) {
            throw new \App\Exceptions\TaskException();
        }
    }

    public function update($id, UpdateTaskDTO $data): void
    {
        $entrega = $this->getById($id, $data->user_id);

        try {
            $entrega->updateOrFail((array) $data);
        } catch (\Exception $e) {
            throw new \App\Exceptions\TaskException($e->getMessage());
        }
    }

    public function destroy(int $id, string $userId): void
    {
        $entrega = $this->getById($id, $userId);

        try {
            $entrega->delete();
        } catch (\Exception $e) {
            throw new \App\Exceptions\TaskException($e->getMessage());
        }
    }
}
