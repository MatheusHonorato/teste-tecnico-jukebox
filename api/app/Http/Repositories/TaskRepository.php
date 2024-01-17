<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(private Task $task)
    {
    }

    public function index(): Paginator
    {
        return $this->task->where('user_id', auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->paginate(10);
    }

    public function create(array $data): Task
    {
        try {
            return $this->task::create($data);
        } catch (\Exception $e) {
            throw new \App\Exceptions\TaskException($e->getMessage());
        }
    }

    public function getById(int $id): Task
    {
        try {
            return $this->task::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            throw new \App\Exceptions\TaskExceptionNotFound();
        } catch (\Exception) {
            throw new \App\Exceptions\TaskException();
        }
    }

    public function update($id, array $data): void
    {
        $entrega = $this->getById($id);

        try {
            $entrega->updateOrFail($data);
        } catch (\Exception $e) {
            throw new \App\Exceptions\TaskException($e->getMessage());
        }
    }

    public function destroy(int $id): void
    {
        $entrega = $this->getById($id);
        try {
            $entrega->delete();
        } catch (\Exception $e) {
            throw new \App\Exceptions\TaskException($e->getMessage());
        }
    }
}
