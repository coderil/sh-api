<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function(RouteNotFoundException $e) {
            return response()->json([
                "message" => 'Unauthenticated'
            ]);
        }); 
        $exceptions->renderable(function(NotFoundHttpException $e) {
            return response()->json([
                "message" => 'Route not found'
            ]);
        }); 
        $exceptions->renderable(function(AccessDeniedHttpException $e) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        });
        $exceptions->renderable(function(ThrottleRequestsException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 429);
        });
    })->create();
