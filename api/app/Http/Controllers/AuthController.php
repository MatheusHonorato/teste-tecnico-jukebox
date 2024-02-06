<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class AuthController extends Controller
{
    public function __construct(private Auth $auth)
    {
    }

    /**
     * @OA\Post(
     *      tags={"Autentication"},
     *      summary="Login",
     *      description="Login",
     *      path="/login",
     *
     *       @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(
     *                  property="token",
     *                  type="string"
     *              ),
     *          )
     *       ),
     *
     *       @OA\Response(
     *           response="204",
     *           description="Authentication",
     *       ),
     *       @OA\Response(
     *           response="400",
     *           description="Bad Request",
     *       ),
     *       @OA\Response(
     *           response="401",
     *           description="Unauthorized",
     *       )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $uid = $this->auth->verifyIdToken($request->token)->claims()->get('sub');

            $token = User::find($uid)->createToken('authToken')->plainTextToken;

            return response()->json(['token_type' => 'Bearer', 'access_token' => $token], JsonResponse::HTTP_OK);

        } catch (FailedToVerifyToken $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_FORBIDDEN);
        }
    }
}
