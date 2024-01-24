<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\CreateTaskDTO;
use App\DTOs\UpdateTaskDTO;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $tasks = $this->taskRepository->index((string) auth()->user()->id);

            return response()->json(
                new TaskResourceCollection($tasks),
                JsonResponse::HTTP_OK
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {

            $data = [...$request->validated(), ...['user_id' => (string) auth()->user()->id]];

            $task = $this->taskRepository->create(new CreateTaskDTO(...$data));

            return response()->json(
                ['data' => new TaskResource($task)],
                JsonResponse::HTTP_CREATED
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(Task $task): JsonResponse
    {
        try {
            $task = $this->taskRepository->getById($task->id, (string) auth()->user()->id);

            return response()->json(
                ['data' => new TaskResource($task)],
                JsonResponse::HTTP_OK
            );
        } catch (\App\Exceptions\TaskExceptionNotFound $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {

            $data = [...$request->validated(), ...['user_id' => (string) auth()->user()->id]];

            $this->taskRepository->update(
                $task->id,
                new UpdateTaskDTO(...$data),
            );

            return response()->json(
                [],
                JsonResponse::HTTP_NO_CONTENT
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        try {

            $this->taskRepository->destroy($task->id, (string) auth()->user()->id);

            return response()->json(
                [],
                JsonResponse::HTTP_NO_CONTENT
            );
        } catch (\App\Exceptions\TaskExceptionNotFound $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
