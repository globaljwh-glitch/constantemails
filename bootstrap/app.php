<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // $middleware->alias([
        //     'admin' => AdminMiddleware::class,
        // ]);
         $middleware->alias([
            'admin' => AdminMiddleware::class,
        'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
        'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
    ]);
        $middleware->api(prepend: [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        \Illuminate\Http\Middleware\HandleCors::class, // built-in CORS handler
    ]);

        $middleware->redirectUsersTo(function () {

            if (! auth()->check()) {
                return route('home');
            }

            $user = auth()->user();

            if ($user->is_admin) {
                return route('admin.dashboard');
            }

            //return route('user.dashboard');
            return redirect('/user/dashboard');
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();