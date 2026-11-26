<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBarber
{
    /**
     * Solo el barbero entra al panel y al admin.
     * Un cliente registrado (o cualquier cuenta sin rol barbero)
     * recibe 403, no el panel con los datos de los clientes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isBarber()) {
            abort(403, 'Solo el barbero puede acceder a esta página.');
        }

        return $next($request);
    }
}
