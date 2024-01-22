<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\NotificationStoreRequest;
use App\Http\Requests\TokenUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebasePushController extends Controller
{
    protected $notification;

    public function __construct()
    {
        $this->notification = Firebase::messaging();
    }

    public function setToken(TokenUpdateRequest $request, User $user): JsonResponse
    {
        try {
            $user->update($request->validated());

            return response()->json([], JsonResponse::HTTP_NO_CONTENT);
        } catch (\App\Exceptions\UserExceptionNotFound $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

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
