<?php

use App\Http\Controllers\Vaccination\VaccinationController;
use App\Http\Controllers\Vaccination\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('vaccination')->group(function () {

    Route::controller(VaccinationController::class)->group(function () {
        Route::get('dashboard', 'index1')->name('vc.dashboard1');
        Route::get('/', 'index')->name('vc.dashboard');

        // Vaccine
        Route::get('/vaccines', 'vaccine')->name('vc.vaccine');
        Route::get('/vaccine-register', 'vaccine_register')->name('vc.vaccine-register');
        Route::get('/edit-vaccine/{id}', 'edit_vaccine')->name('vc.edit-vaccine');
        Route::post('/update-vaccine-register/{id?}', 'update_vaccine_register')->name('vc.update-vaccine-register');

        // Vaccination
        Route::get('/vaccination-lists', 'vaccination')->name('vc.vaccination');
        Route::get('/vaccination-register', 'vaccination_register')->name('vc.vaccination-register');
        Route::get('/edit-vaccination/{id}', 'edit_vaccination')->name('vc.edit-vaccination');
        Route::get('/view-vaccination/{id}', 'view_vaccination')->name('vc.view-vaccination');
        Route::post('/update-vaccination-register/{id?}', 'update_vaccination_register')->name('vc.update-vaccination-register');

        // Reports
        Route::get('/listing-aefi-reports', 'listing_aefi_reports')->name('vc.listing-aefi-reports');
        Route::get('/aefi-reports', 'aefi_reports')->name('vc.aefi-reports');
        Route::post('/update-aefi-reports/{id?}', 'update_aefi_reports')->name('vc.update-aefi-reports');

        // Vendor
        Route::get('/vendors', 'listing_vendor')->name('vc.listing-vendor');
        Route::get('/add-vendor', 'add_vendor')->name('vc.add-vendor');
        Route::get('/edit-vendor/{id?}', 'edit_vendor')->name('vc.edit-vendor');
        Route::post('/update-vendor/{id?}', 'update_vendor')->name('vc.update-vendor');

        Route::post('/get-vaccine-unit-and-sub-unit', 'getUnitDetails')->name('vc.get-vaccine-unit-and-sub-unit');

    });

    Route::controller(PurchaseController::class)->group(function () {

        //Purchase

        Route::get('/listing-purchase', 'listing_purchase')->name('vc.listing-purchase');
        Route::get('/add-purchase', 'add_purchase')->name('vc.add-purchase');
        Route::get('/edit-purchase/{id?}', 'edit_purchase')->name('vc.edit-purchase');
        Route::post('/update-purchase/{id?}', 'update_purchase')->name('vc.update-purchase');
        Route::get('/purchase-info/{id?}', 'purchase_details')->name('vc.purchase-details');
        Route::get('/delete-purchase/{id?}', 'delete_purchase')->name('vc.delete-purchase');

        //Stock
        Route::get('/stock-details', 'stock_details')->name('vc.stock-details');
        Route::get('/stock-info/{id?}', 'stock_info')->name('vc.stock-info');
    });

});
