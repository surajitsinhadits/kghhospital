<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CSSD\CssdController;
use App\Http\Controllers\Bill\PDFController;

Route::middleware(['auth'])->prefix('cssd')->group(function () {
    Route::controller(CssdController::class)->group(function () {
          //Medical Instruments
        Route::get('/medical_instruments','medical_instruments')->name('cssd.medical_instruments');
        Route::get('/edit-medical-instruments/{id?}', 'edit_medical_instruments')->name('cssd.edit-medical-instruments');
        Route::post('/update-medical-instruments','update_medical_instruments')->name('cssd.update-medical-instruments');

        // Kit Box
        Route::get('/kit-box','kit_box')->name('cssd.kit-box');
        Route::post('/kitboxes-create','kitboxes_create')->name('cssd.kitboxes-create');
        Route::get('/kitboxes-details/{id?}','kitboxes_details')->name('cssd.kitboxes-details');
        Route::get('/kitboxes-edit/{id?}','kitboxes_edit')->name('cssd.kitboxes-edit');

        //Serilization
        Route::get('/sterilization','sterilization')->name('cssd.sterilization');
        Route::get('/kitboxes_sterilize/{id?}', 'markSterilized')->name('cssd.markSterilized');
        Route::get('/kitboxes_send_to_sterilize/{id?}', 'sendToSterilized')->name('cssd.sendToSterilized');

        //Category
        Route::get('/category','category')->name('cssd.category');
        Route::post('/save-category/{id?}','save_update_category')->name('cssd.add-update-category');
        Route::get('/edit-category/{id?}','edit_category')->name('cssd.edit-category');

    });
});