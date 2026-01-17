<?php

namespace Betta\Terms\Middleware;

use Betta\Terms\Terms;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PanelConsentGuard
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Terms::guardDisabled()) {
            return $next($request);
        }

        if (Terms::panelMustConsent() and ! Terms::onConsentUrl()) {
            Terms::intendedUrl($request->url());

            return redirect(Terms::getConsentUrl());
        }

        return $next($request);
    }
}
