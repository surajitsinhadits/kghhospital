<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Callcenter\CallCenterController;

Route::middleware(['auth'])->prefix('callcenter')->group(function () {

    Route::controller(CallCenterController::class)->group(function () {
        
        Route::any('/', 'index')->name('callcenter.dashboard');
        Route::any('/save-call-center', 'save_call_center')->name('callcenter.save-call-center');
        Route::any('/callcenter-appointment-list', 'callcenter_appointment_list')->name('callcenter.appointment-list');
        Route::get('/appointment-details-form/{id}', 'appointment_details_form')->name('callcenter.details-form');
        Route::post('/save-details/{id?}', 'save_details')->name('callcenter.save-details');

    });

});