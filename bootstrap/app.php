<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/payroll.php',
            __DIR__.'/../routes/opd.php',
            __DIR__.'/../routes/emg.php',
            __DIR__.'/../routes/ipd.php',
            __DIR__.'/../routes/investigation.php',
            __DIR__.'/../routes/bill.php',
            __DIR__.'/../routes/vaccination.php',
            __DIR__.'/../routes/store.php',
            __DIR__.'/../routes/pharmacy.php',
            __DIR__.'/../routes/reports.php',
            __DIR__.'/../routes/cssd.php',
            __DIR__.'/../routes/callcenter.php',
            __DIR__.'/../routes/operation.php',
            __DIR__.'/../routes/bloodBank.php',
            __DIR__.'/../routes/kitchen.php',
            __DIR__.'/../routes/laundry.php',
            __DIR__.'/../routes/vaccination.php',
            __DIR__.'/../routes/ivf.php',
        ],
        api: [
            __DIR__.'/../routes/api/api.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
