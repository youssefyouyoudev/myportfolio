<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ForceNonWww;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Globally prepend www → non-www 301 redirect (SEO canonical fix).
        $middleware->prepend(ForceNonWww::class);

        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'setLocale' => SetLocale::class,
            'bindings' => SubstituteBindings::class,
        ]);

        // Ensure implicit route model binding runs for web routes (required for {service:slug} etc.).
        $middleware->web(append: [
            SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
