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
use App\Interfaces\TaskServiceInterface;
use App\Models\Task;
use App\Utils\TaskUtil;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskServiceInterface $taskService
    ) {
    }

    /**
     * @OA\Get(
     *      tags={"Tasks"},
     *      summary="Get list of tasks",
     *      description="Get list of tasks",
     *      path="/tasks",
     *      security={{ "bearerAuth": {}}},
     *
     *       @OA\Parameter(
     *           name="page",
     *           in="query",
     *           description="Page number",
     *
     *           @OA\Schema(
     *               type="integer",
     *               default="1"
     *           ),
     *       ),
     *
     *       @OA\Response(
     *           response="200",
     *           description="List of tasks",
     *       ),
     *       @OA\Response(
     *           response="500",
     *           description="Internal server error",
     *       )
     * )
     */
    public function index(): JsonResponse
    {
        try {

            $tasks = $this->taskService->index(auth()->user()->id, request()->page ?? '1');

            return response()->json(new TaskResourceCollection($tasks), JsonResponse::HTTP_OK);
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Post(
     *      tags={"Tasks"},
     *      summary="Create new task",
     *      description="Create new task",
     *      path="/tasks",
     *      security={{ "bearerAuth": {}}},
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(
     *                  property="title",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string"
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response="201",
     *          description="Created task",
     *       ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal server error",
     *       )
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $data = TaskUtil::mountTaskUser($request->validated(), auth()->user()->id);

            $task = $this->taskRepository->create(new CreateTaskDTO(...$data));

            return response()->json(['data' => new TaskResource($task)], JsonResponse::HTTP_CREATED);
        } catch (\App\Exceptions\TaskException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @OA\Get(
     *      tags={"Tasks"},
     *      summary="Show task",
     *      description="Show task",
     *      path="/tasks/{task}",
     *      security={{ "bearerAuth": {}}},
     *
     *      @OA\Parameter(
     *          name="task",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response="200",
     *          description="Show task",
     *       ),
     *       @OA\Response(
     *          response="404",
     *          description="Not found",
     *       ),
     *       @OA\Response(
     *          response="500",
     *          description="Internal server error",
     *       )
     * )
     */
    public function show(Task $task): JsonResponse
    {
        try {
            $task = $this->taskService->show($task->id, auth()->user()->id);

            return response()->json(['data' => new TaskResource($task)], JsonResponse::HTTP_OK);
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

    /**
     * @OA\Put(
     *      tags={"Tasks"},
     *      summary="Update task",
     *      description="Update task",
     *      path="/tasks/{task}",
     *      security={{ "bearerAuth": {}}},
     *
     *      @OA\Parameter(
     *          name="task",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(
     *                  property="title",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string"
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response="204",
     *          description="Updated task",
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found",
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal server error",
     *      )
     * )
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {

            $data = TaskUtil::mountTaskUser($request->validated(), auth()->user()->id);

            $this->taskRepository->update($task->id, new UpdateTaskDTO(...$data));

            return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
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

    /**
     * @OA\Delete(
     *      tags={"Tasks"},
     *      summary="Delete task",
     *      description="Delete task",
     *      path="/tasks/{task}",
     *      security={{ "bearerAuth": {}}},
     *
     *      @OA\Parameter(
     *          name="task",
     *          in="path",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response="204",
     *          description="Destroyed task",
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found",
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal server error",
     *      ),
     * )
     */
    public function destroy(Task $task): JsonResponse
    {
        try {
            $this->taskRepository->destroy($task->id, auth()->user()->id);

            return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
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
