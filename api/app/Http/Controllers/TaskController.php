<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\TaskInputDTO;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Contracts\TaskRepositoryInterface;
use App\Contracts\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index(Request $request): JsonResponse
    {
        try {
            $tasks = $this->taskService->index($request->user_id, $request->query('page', '1'));

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
    public function store(TaskRequest $request): JsonResponse
    {
        try {
            $fields = $request->only(['title', 'description', 'user_id']);

            $task = $this->taskRepository->create(new TaskInputDTO(...$fields));

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
    public function show(int $id): JsonResponse
    {
        try {
            $task = $this->taskService->show($id);

            $this->authorize('view', $task);

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
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_FORBIDDEN
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
    public function update(TaskRequest $request, int $id): JsonResponse
    {
        try {
            $task = $this->taskRepository->getById($id);

            $this->authorize('update', $task);

            $fields = $request->only(['title', 'description', 'user_id']);

            $this->taskRepository->update($task->id, new TaskInputDTO(...$fields));

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
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_FORBIDDEN
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
    public function destroy(int $id): JsonResponse
    {
        try {
            $task = $this->taskRepository->getById($id);

            $this->authorize('delete', $task);

            $this->taskRepository->destroy($task->id);

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
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                JsonResponse::HTTP_FORBIDDEN
            );
        }
    }
}
