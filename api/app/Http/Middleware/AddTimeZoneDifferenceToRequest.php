<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddTimeZoneDifferenceToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ajuste necessário, pois existe uma pequena diferença entre o timezone do servidor e da api gerando problemas ao verificar o token no back-end.
        // Tentei alterar configurações de timezone no painel do firebase e na aplicação, mas não obtive sucesso.
        sleep(2);

        return $next($request);
    }
}
