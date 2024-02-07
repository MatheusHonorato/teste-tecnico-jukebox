<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\NotificationStoreRequest;
use App\Jobs\SendNotification;
use Illuminate\Http\JsonResponse;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebasePushController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @OA\Post(
     *      tags={"Firebase"},
     *      summary="Send Notification firebase",
     *      description="Send Notification firebase",
     *      path="/notifications",
     *      security={{ "bearerAuth": {}}},
     *
     *       @OA\RequestBody(
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
     *       ),
     *
     *       @OA\Response(
     *           response="204",
     *           description="Send notification",
     *       ),
     *       @OA\Response(
     *           response="500",
     *           description="Internal server error",
     *       )
     * )
     */
    public function notification(NotificationStoreRequest $request): JsonResponse
    {
        try {
            SendNotification::dispatch(
                new Firebase(),
                auth()->user()->fcm_token,
                $request->validated()
            )->onQueue('firebase')->delay(now()->addMinutes(1));

            return response()->json([], JsonResponse::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
