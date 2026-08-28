<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OT\OTScheduleController;
use App\Http\Controllers\OT\OTMasterController;



Route::middleware(['auth'])->prefix('ot')->group(function () {
    Route::controller(OTScheduleController::class)->group(function () {

        //  Route::get('/','index')->name('OT.index');

        Route::get('/ot-schedule', 'getOTSchedule')->name('ot.ot-schedule');
        Route::any('/ot-schedule-calender', 'calendarEvents')->name('ot.ot-calendar-events');
        Route::any('/add-operation/{section?}/{section_id?}', 'add_operation')->name('ot.add-operation');
        Route::post('/save-operation', 'save_operation')->name('ot.save-operation');
        Route::get('/ot-listing', 'ot_list')->name('ot.all-ot-listing');
        Route::get('/ot-info/{id?}', 'ot_info')->name('ot.ot-info');
        Route::any('/add-operation-details/{section?}/{section_id?}', 'add_operation_schedule_details')->name('ot.add-operation-details');
        Route::post('/save-operation-request', 'save_operation_request')->name('ot.save-operation-request');
        Route::post('/update-operation-request', 'update_operation_request')->name('ot.update-operation-request');

        Route::get('/ot-preparation/{section?}/{id?}', 'ot_preparation')->name('ot.ot-preparation');
        Route::post('/save-ot-preparation', 'save_ot_preparation')->name('ot.save-ot-preparation');
        Route::post('/update-ot-preparation', 'update_ot_preparation')->name('ot.update-ot-preparation');

        Route::get('/ot-schedule-confirmation/{section?}/{id?}', 'ot_schedule_confirmation')->name('ot.ot-schedule-confirmation');
        Route::post('/save-ot-schedule', 'save_ot_schedule')->name('ot.save-ot-schedule');
        Route::post('/update-ot-schedule', 'update_ot_schedule')->name('ot.update-ot-schedule');
        Route::get('/ot-progress/{section?}/{id?}', 'ot_progress')->name('ot.ot-progress');
        Route::post('/save-ot-progress', 'save_ot_progress')->name('ot.save-ot-progress');
        Route::post('/update-ot-progress', 'update_ot_progress')->name('ot.update-ot-progress');

        Route::post('/update-ot-prepation-test', 'ot_test_preparation_update')->name('ot.update-ot-prepation-test');

        Route::get('/ot-progress-percentage/{id?}','getProgressPercentage')->name('ot.get-progress-percentage');

    });

    Route::controller(OTMasterController::class)->group(function () {
        
        Route::get('/create-ot-package', 'create_package')->name('ot.create-ot-package');
        Route::post('/update-create-package/{id?}', 'update_create_package')->name('ot.update-create-package');
        Route::get('/edit-create-package/{id?}', 'edit_create_package')->name('ot.edit-create-package');
        Route::post('/get-package-details', 'get_package_details')->name('ot.get-package-details');
        Route::post('/get-ot-procedure', 'get_procedures')->name('ot.get-ot-procedure');

    });
});
