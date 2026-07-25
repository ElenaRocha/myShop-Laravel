<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidToken
{
    public function handle(Request $request, Closure $next, string $token): Response
    {
        // El token esperado llega como parámetro del middleware
        if ($request->query('token') !== $token) {
            abort(403, 'Token inválido o ausente.');
        }

        return $next($request);
    }
}
