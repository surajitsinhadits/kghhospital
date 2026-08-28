<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EMG\EMGController;

Route::middleware(['auth'])->prefix('emg')->group(function () {

    Route::controller(EMGController::class)->group(function () {
        // emg
        Route::get('/emg-registation', 'emg_registation')->name('emg.registation');
        Route::post('/get-doctors', 'get_doctors')->name('emg.get-doctors');
        Route::post('/emg-doctor-charge', 'emg_doctor_charge')->name('emg.emg-doctor-charge');
        Route::post('/get-patients', 'get_patients')->name('emg.get-patients');
        Route::post('/find-doctor-charge-by-doctor', 'find_doctor_charge_by_doctor')->name('emg.find-doctor-charge-by-doctor');
        Route::post('/update-emg-register', 'update_emg_register')->name('emg.update-emg-register');
        Route::get('/emg-patient-list','index')->name('emg.patient-list');
    });

});
