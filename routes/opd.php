<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OPD\OPDController;
use App\Http\Controllers\OPD\SlotController;


Route::middleware(['auth'])->prefix('opd')->group(function () {
    Route::controller(OPDController::class)->group(function () {
        // opd
        Route::get('/', 'index')->name('opd.opd');
        Route::get('/opd-register/{id?}', 'opd_register')->name('opd.opd-register');
        Route::post('/opd-doctor-charge', 'opd_doctor_charge')->name('opd.opd-doctor-charge');
        Route::post('/update-opd-register', 'update_opd_register')->name('opd.update-opd-register');

        Route::post('/update-aadhaar-card', 'update_aadhaar_card')->name('opd.update-aadhaar-card');

        // enquiry & appointment
        Route::any('/appointments', 'appointments')->name('opd.appointments');
        Route::any('/add-enquiry', 'add_enquiry')->name('opd.add-enquiry');
        Route::post('/save-enquiry', 'save_enquiry')->name('opd.save-enquiry');
        Route::get('/delete-appointment/{id}', 'delete_appointment')->name('opd.delete-appointment');
        Route::post('/get-patients', 'get_patients')->name('opd.get-patients');
        Route::post('/get-doctors', 'get_doctors')->name('opd.get-doctors');
        Route::post('/get-schedule', 'get_schedule')->name('opd.get-schedule');
        Route::post('/get-timeslot', 'get_timeslot')->name('opd.get-timeslot');
        Route::post('/change-timeslot', 'change_timeslot')->name('opd.change-timeslot');
    });
    Route::controller(SlotController::class)->group(function () {
        // doctors-schedule
        Route::any('/doctors-schedule', 'doctors_schedule')->name('opd.doctors-schedule');
        Route::post('/get-all-time-schedule', 'get_all_time_schedule')->name('opd.get-all-time-schedule');

        // time-schedule
        Route::get('/view-time-schedule', 'view_time_schedule')->name('opd.view-time-schedule');
        Route::post('/save-time-schedule', 'save_time_schedule')->name('opd.save-time-schedule');
        Route::post('/active-slot', 'active_slot')->name('opd.active-slot');
        Route::post('/update-slot', 'update_slot')->name('opd.update-slot');
        Route::post('/delete-slot', 'delete_slot')->name('opd.delete-slot');
    });
});
