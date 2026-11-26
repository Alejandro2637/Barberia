<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectSegunRol($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectSegunRol($request);
    }

    private function redirectSegunRol(EmailVerificationRequest $request): RedirectResponse
    {
        $destino = $request->user()->isBarber()
            ? route('dashboard', absolute: false).'?verified=1'
            : url('/?verified=1');

        return redirect()->intended($destino);
    }
}
