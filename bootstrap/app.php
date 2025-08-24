<?php

use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function(){

            // Api Routes
            Route::middleware(['api','apiKey'])->prefix('api/v1/auth')->group(base_path('routes/api/v1/auth.php'));
            Route::middleware(['api','apiKey','auth:sanctum'])->prefix('api/v1')->group(base_path('routes/api/v1/user.php'));
        },
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'apiKey' => ApiKeyMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                $statusCode = 500;
                $message    = $e->getMessage();
                $data       = [];

                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    $statusCode = $e->getStatusCode();
                } elseif ($e instanceof AuthenticationException) {
                    $statusCode = 401;
                } elseif ($e instanceof ValidationException) {
                    $statusCode = 422;
                }

                return response()->json([
                    'status'  => false,
                    'message' => $message ?: 'Something went wrong',
                    'code'    => $statusCode,
                    'data'    => $data,
                ], $statusCode);
            }

            return null;
        });
    })->create();
