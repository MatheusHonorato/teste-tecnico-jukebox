<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\NotificationStoreRequest;
use App\Http\Requests\TokenUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebasePushController extends Controller
{
    protected $notification;

    public function __construct()
    {
        $this->notification = Firebase::messaging();
    }

    /**
     * @OA\Post(
     *      tags={"Firebase"},
     *      summary="Set token firebase",
     *      description="Set token firebase",
     *      path="/tokens",
     *      security={{ "bearerAuth": {}}},
     *       @OA\Parameter(
     *           name="user",
     *           in="path",
     *           required=true,
     *           @OA\Schema(
     *               type="string",
     *           ),
     *       ),
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="fcm_token",
     *                  type="string"
     *              ),
     *          )
     *       ),
     *       @OA\Response(
     *           response="204",
     *           description="Created token",
     *       ),
     *      @OA\Response(
     *           response="500",
     *           description="Internal server error",
     *       )
     * )
     *
     */
    public function setToken(TokenUpdateRequest $request, User $user): JsonResponse
    {
        try {
            $user->update($request->validated());

            return response()->json([], JsonResponse::HTTP_NO_CONTENT);
        } catch (\App\Exceptions\UserExceptionNotFound $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @OA\Post(
     *      tags={"Firebase"},
     *      summary="Send Notification firebase",
     *      description="Send Notification firebase",
     *      path="/notifications",
     *      security={{ "bearerAuth": {}}},
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="title",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string"
     *              ),
     *          )
     *       ),
     *       @OA\Response(
     *           response="204",
     *           description="Send notification",
     *       ),
     *       @OA\Response(
     *           response="500",
     *           description="Internal server error",
     *       )
     * )
     *
     */
    public function notification(NotificationStoreRequest $request): JsonResponse
    {
        try {
            $message = CloudMessage::fromArray([
                'token' => auth()->user()->fcm_token,
                'notification' => $request->validated(),
            ]);

            $this->notification->send($message);

            return response()->json([], JsonResponse::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
