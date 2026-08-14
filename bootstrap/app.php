<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        $middleware->redirectUsersTo(function () {

            if (! auth()->check()) {
                return route('home');
            }

            $user = auth()->user();

            if ($user->is_admin) {
                return route('admin.dashboard');
            }

            return route('user.dashboard');
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();