<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Cabeceras de seguridad para todas las respuestas web.
     *
     * CSP: permite lo que el proyecto ya usa (Tailwind por CDN,
     * imágenes de Unsplash, iframe de Google Maps, Alpine/Livewire
     * con inline) y bloquea el resto. Sin 'unsafe-inline' se romperían
     * las vistas actuales; se mantiene como compromiso documentado.
     * Referrer-Policy no-referrer: la URL con el token de cancelación
     * no se filtra a Google Maps ni a Unsplash en la cabecera Referer.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = "default-src 'self'; "
            ."script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com; "
            ."style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; "
            ."img-src 'self' data: https://images.unsplash.com https://www.google.com https://maps.gstatic.com; "
            ."frame-src https://www.google.com; "
            ."font-src 'self' data:; "
            ."connect-src 'self'; "
            ."object-src 'none'; base-uri 'self'; form-action 'self'";

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Solo tiene efecto por HTTPS; por HTTP el navegador la ignora.
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
