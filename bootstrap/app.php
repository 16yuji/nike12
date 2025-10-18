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
        // Alias cho route middleware
        $middleware->alias([
            // có sẵn 'auth' của Laravel; bạn thêm:
            'is_admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            // nếu có dùng xác minh email của Breeze:
            // 'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        // (tuỳ chọn) nếu muốn thêm global middleware hay group thì thêm ở đây:
        // $middleware->append(\App\Http\Middleware\SomeGlobalMiddleware::class);
        // $middleware->web([...]); // để thêm vào nhóm 'web'
        // $middleware->api([...]); // để thêm vào nhóm 'api'
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
