<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('laundry')->group(function () {
    // Laundry
    Route::controller(LaundryController::class)->group(function () {
        Route::get('/laundry/request', 'create');
        Route::post('/laundry/request', 'store')->name('laundry.store');
        Route::get('/laundry/status', 'status');
    });
});
