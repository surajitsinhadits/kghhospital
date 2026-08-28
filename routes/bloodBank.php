<?php

use App\Http\Controllers\BloodBank\BloodBankController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('blood-bank')->group(function () {

    // Route::get('/get-blood-groups', [BloodBankController::class, 'getBloodGroups'])->name('get.blood.groups');

    // Route::controller(BloodBankController::class)->group(function () {
    //     Route::get('get-doner-details', 'get_donor_details')->name('bl.doner-details');
    //     Route::get('store-blood/{id}', 'store_blood')->name('bl.store-blood');
    //     Route::get('return-to-inventory/{id}', 'return_to_inventory')->name('bl.return-to-inventory');
    //     Route::get('view-and-approve/{id}', 'view_and_approve')->name('bl.view-and-approve');
    // });

    //BLOOD DASHBOARD
    Route::get('dashboard', [BloodBankController::class, 'index1'])->name('bl.dashboard1');
    
    //BLOOD REPORT
    Route::get('/', [BloodBankController::class, 'index'])->name('bl.dashboard');
    Route::get('blood-report', [BloodBankController::class, 'blood_report'])->name('bl.blood_report');
    Route::get('get-availale-blood',  [BloodBankController::class, 'get_available_blood'])->name('bl.available-blood');
    Route::get('get-issued-blood',  [BloodBankController::class, 'get_issued_blood'])->name('bl.issued-blood');
    Route::get('get-expired-blood',  [BloodBankController::class, 'get_expired_blood'])->name('bl.expired-blood');
    Route::get('remove-blood-issue/{bill_id}',  [BloodBankController::class, 'remove_blood_issue'])->name('bl.remove-blood-issue');

    //Blood collection
    Route::controller(BloodBankController::class)->group(function () {
        Route::get('blood-collection-list', 'get_blood_collection')->name('bl.get-blood-collection');
        Route::get('blood-collection', 'blood_collection')->name('bl.blood-collection');
        Route::post('blood-collection-save', 'blood_collection_save')->name('bl.blood-collection-save');
        Route::get('blood-collection-edit/{id}', 'blood_collection_edit')->name('bl.blood.collection.edit');
    });

    //Blood Testing
    Route::controller(BloodBankController::class)->group(function () {
        Route::get('get-blood-testing', 'get_blood_testing')->name('bl.get-blood-testing');
        Route::post('blood-testing-save', 'blood_testing_save')->name('bl.blood-testing-save');
        Route::get('blood-testing-edit/{id}', 'blood_testing_edit')->name('bl.blood.testing.edit');
        Route::get('blood-testing-info/{id}', 'blood_testing_info')->name('bl.blood-testing-info');
    });

    //Approval and Stock
    Route::controller(BloodBankController::class)->group(function () {
        Route::get('approval-stock', 'get_approval_stock')->name('bl.get-approval-stock');
        Route::get('approval-stock-edit/{id}', 'approval_stock_edit')->name('bl.approval.stock.edit');
    });

    //Issue
    Route::controller(BloodBankController::class)->group(function () {
        Route::post('doner-data', 'get_doner_available_blood')->name('get.donor.data');
        Route::post('save-blood-issue', 'save_blood_issue')->name('bl.save-blood-issue');
        Route::post('get-blood-by-barcode', 'get_blood_by_barcode')->name('bl.get-blood-by-barcode');
        Route::get('get-blood-stock', 'get_blood_stock')->name('bl.get-blood-stock');
        Route::get('get-blood-issue', 'get_blood_issue')->name('bl.get-blood-issue');
    });

    // Receptant
    Route::controller(BloodBankController::class)->group(function () {
        Route::get('get-receptant', 'get_receptant')->name('bl.get-receptant');
        Route::get('receptant-register', 'receptant_register')->name('bl.receptant-register');
        Route::post('receptant-save', 'receptant_save')->name('bl.receptant-save');
        Route::get('receptant-edit/{id}', 'receptant_edit')->name('bl.receptant-edit');
    });

    //Donor
    Route::controller(BloodBankController::class)->group(function () {
        Route::get('doners', 'get_donor')->name('bl.doners');
        Route::get('doner-register', 'doner_register')->name('bl.doner-register');
        Route::post('doner-save', 'doner_save')->name('bl.doner-save');
        Route::get('edit-doner/{id}', 'doner_edit')->name('bl.doner-edit');
        Route::post('doner-info', 'get_doner_info')->name('bl.doner-info');
    });

    //Camp
    Route::controller(BloodBankController::class)->group(function () {
        Route::get('donation-camps', 'get_camp')->name('bl.donation-camps');
        Route::get('camp-register', 'register_camp')->name('bl.camp-register');
        Route::get('edit-camps/{id}', 'camp_edit')->name('bl.camp-edit');
        Route::post('camp-save', 'camp_save')->name('bl.camp-save');
    });
});
