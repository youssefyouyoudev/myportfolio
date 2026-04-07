<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class SetLocale
{
    /**
     * Handle an incoming request by enforcing locale prefixes and setting the app locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported = ['en', 'fr', 'ar', 'es', 'de'];

        $requested = $request->query('lang') ?? $request->query('locale');
        $routeLocale = $request->route('locale');
        $sessionLocale = $request->session()->get('app_locale');

        if (
            $request->isMethod('GET')
            && $requested
            && in_array($requested, $supported, true)
            && $routeLocale !== $requested
            && $request->route()?->getName()
        ) {
            $parameters = Arr::except($request->route()->parameters(), ['locale']);
            $parameters['locale'] = $requested;

            $query = Arr::except($request->query(), ['lang', 'locale']);

            return redirect()->route($request->route()->getName(), array_merge($parameters, $query));
        }

        $locale = $routeLocale && in_array($routeLocale, $supported, true)
            ? $routeLocale
            : ($requested && in_array($requested, $supported, true)
                ? $requested
            : ($sessionLocale && in_array($sessionLocale, $supported, true)
                ? $sessionLocale
                : $request->getPreferredLanguage($supported)));

        $locale = $locale && in_array($locale, $supported, true)
            ? $locale
            : (config('app.locale', 'en') ?? 'en');

        app()->setLocale($locale);
        Carbon::setLocale($locale);
        URL::defaults(['locale' => $locale]);
        view()->share('appLocale', $locale);
        view()->share('isRtl', $locale === 'ar');
        $request->session()->put('app_locale', $locale);

        return $next($request);
    }
}
