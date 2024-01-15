<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception): Response
    {

        $statusCode = $this->isHttpException($exception) ? $exception->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;

        $message = $exception->getMessage();

        if(str_contains($message, "No query results for model")) {
            $message = 'Not found';
            $statusCode = JsonResponse::HTTP_NOT_FOUND;
        }

        return response()->json([
            'error' => class_basename($exception),
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
