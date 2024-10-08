<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user-auth'=>App\Http\Middleware\UserMiddleware::class,
            'head-auth'=> App\Http\Middleware\HeadMiddleware::class,
            'auth-check'=> App\Http\Middleware\LoginCheckMiddleware::class,
            'lang' => App\Http\Middleware\LocalizationMiddleware::class,
        ]);

        $middleware->web(append:[
            App\Http\Middleware\LocalizationMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
