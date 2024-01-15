<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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
            $tasks = $this->taskRepository->index();

            return response()->json(
                ['status' => false, 'data' => $tasks],
                JsonResponse::HTTP_OK
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['status' => false, 'message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = $this->taskRepository->create($request->validated());

            return response()->json(
                ['status' => true, 'data' => $task],
                JsonResponse::HTTP_CREATED
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['status' => false, 'message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(Task $task): JsonResponse
    {
        try {
            $task = $this->taskRepository->getById($task->id);

            return response()->json(
                ['status' => true, 'data' => $task],
                JsonResponse::HTTP_OK
            );
        } catch (\App\Exceptions\TaskExceptionNotFound $e) {
            return response()->json(
                ['status' => false, 'message' => $e->getMessage()],
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['status' => false, 'message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $this->taskRepository->update($task->id, $request->validated());

            return response()->json(
                ['status' => true, 'data' => $task],
                JsonResponse::HTTP_NO_CONTENT
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['status' => false, 'message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(Task $task)
    {
        try {
            $this->taskRepository->destroy($task->id);

            return response()->json(
                ['status' => true],
                JsonResponse::HTTP_NO_CONTENT
            );
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['status' => false, 'message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
