<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AuthController
{
    protected $auth;
    public function __construct()
    {
        $this->auth = Firebase::auth();
    }

    public function login(LoginRequest $request)
    {
        try {

            // Ajuste necessário pois existe uma pequena diferença entre o timezone do servidor e da api gerando problemas ao verificar o token no back-end.
            // Tentei alterar configurações de timezone no painel do firebase e na aplicação, mas não obtive sucesso.
            $this->delayTimeZoneDiference();

            $verifiedIdToken = $this->auth->verifyIdToken($request->token);

            $uid = $verifiedIdToken->claims()->get('sub');

            $token = User::find($uid)->createToken('authToken')->plainTextToken;

            return response()->json(
                ['status' => true,'token_type' => 'Bearer','access_token' => $token],
                JsonResponse::HTTP_OK
            );

        } catch (FailedToVerifyToken $e) {
            return response()->json(['status' => false, 'error' => 'Bad request', 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return response()->json(['status' => false, 'error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
    }

    private function delayTimeZoneDiference(): void
    {
        sleep(2);
    }

}
