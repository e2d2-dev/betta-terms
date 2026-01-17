<?php

namespace Betta\Terms\Middleware;

use Betta\Terms\Terms;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Consent
{
    public function handle(Request $request, Closure $next, ?string $guard = null): Response
    {
        if (Terms::consentDisabled()) {
            return $next($request);
        }

        if (Terms::onConsentUrl()) {
            return $next($request);
        }

        if ($guard !== null) {
            Terms::sessionGuard($guard);

            Terms::intendedUrl($request->url());

            return redirect(Terms::getConsentUrl());
        }

        return $next($request);
    }
}
