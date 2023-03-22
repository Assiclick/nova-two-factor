<?php

namespace Visanduma\NovaTwoFactor\Http\Middleware;

use Closure;
use Visanduma\NovaTwoFactor\TwoFaAuthenticator;

class TwoFa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request                             $request
     * @param  Closure                                              $next
     * @return mixed
     * @throws \PragmaRX\Google2FA\Exceptions\InsecureCallException
     */
    public function handle($request, Closure $next)
    {
        $except = [
            'nova-vendor/nova-two-factor/authenticate',
            'nova-vendor/nova-two-factor/recover',
            'nova/logout',
        ];

        if (! config('nova-two-factor.enabled') || in_array($request->path(), $except)) {
            return $next($request);
        }

        if (auth()->user()->hasNotTwoFactorAuthentication()) {
            return $next($request);
        }

        if (
            auth()->user()->hasTwoFactorAuthentication() &&
            auth()->user()->hasTwoFactorAuthenticationNotEnable()
        ) {
            return $next($request);
        }

        $authenticator = app(TwoFaAuthenticator::class)->boot($request);

        if (auth()->guest() || $authenticator->isAuthenticated()) {
            return $next($request);
        }

        return response(view('nova-two-factor::sign-in'));
    }
}
