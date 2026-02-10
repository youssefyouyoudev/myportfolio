<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SetLocale
{
    /**
     * Handle an incoming request by enforcing locale prefixes and setting the app locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported = ['en', 'fr', 'ar'];

        $requested = $request->get('lang') ?? $request->get('locale');
        $sessionLocale = $request->session()->get('app_locale');

        $locale = $requested && in_array($requested, $supported, true)
            ? $requested
            : ($sessionLocale && in_array($sessionLocale, $supported, true)
                ? $sessionLocale
                : $request->getPreferredLanguage($supported));

        $locale = $locale && in_array($locale, $supported, true)
            ? $locale
            : (config('app.locale', 'en') ?? 'en');

        app()->setLocale($locale);
        Carbon::setLocale($locale);
        view()->share('appLocale', $locale);
        view()->share('isRtl', $locale === 'ar');
        $request->session()->put('app_locale', $locale);

        return $next($request);
    }
}
