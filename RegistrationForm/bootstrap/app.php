<?php

use App\Http\Middleware\Admin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Exceptions\FailedToLogin;


if (file_exists(dirname(__DIR__) . '/.env')) {
    Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();
}

$app = new Illuminate\Foundation\Application(
    dirname(__DIR__)
);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append:[
            App\Http\Middleware\LocalizationMiddleware::class,

        ]);

        $middleware->alias([
            'admin' => Admin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->renderable(function (FailedToLogin $e) {
            return $e->render();
        });
        //
    })->create();
