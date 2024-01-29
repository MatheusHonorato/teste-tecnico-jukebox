<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(
 *      url="http://localhost",
 *      description="Swagger API Documentation"
 * ),
 *
 * @OA\Info(
 *      version="1.0.0",
 *      title="Swagger API Documentation",
 * )
 *
 * @OA\SecurityScheme(
 *      type="http",
 *      scheme="bearer",
 *      securityScheme="bearerAuth",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
