<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TokenUpdateRequest;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @OA\Post(
     *      tags={"Token"},
     *      summary="Set token firebase",
     *      description="Set token firebase",
     *      path="users/{user}/tokens",
     *      security={{ "bearerAuth": {}}},
     *
     *       @OA\Parameter(
     *           name="user",
     *           in="path",
     *           required=true,
     *
     *           @OA\Schema(
     *               type="string",
     *           ),
     *       ),
     *
     *       @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(
     *                  property="fcm_token",
     *                  type="string"
     *              ),
     *          )
     *       ),
     *
     *       @OA\Response(
     *           response="204",
     *           description="Updated user token",
     *       ),
     *      @OA\Response(
     *           response="500",
     *           description="Internal server error",
     *       )
     * )
     */
    public function setToken(TokenUpdateRequest $request, string $id): JsonResponse
    {
        try {
            $this->userRepository->setToken($id, $request->fcm_token);

            return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
        } catch (\App\Exceptions\UserException $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
