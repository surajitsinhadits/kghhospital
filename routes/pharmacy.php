<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pharmacy\PharmacyController;
use App\Http\Controllers\Pharmacy\MedInventoryController;

Route::middleware(['auth'])->prefix('pharmacy')->group(function () {
    Route::controller(PharmacyController::class)->group(function () {
        // pharmacy
        Route::get('/', 'index')->name('pharmacy.index');
        Route::get('/medicine-vendor/{id?}', 'medicine_vendor')->name('pharmacy.medicine-vendor');
        Route::any('/update-medicine-vendor/{id?}', 'update_medicine_vendor')->name('pharmacy.update-medicine-vendor');

        Route::get('/add-medicine/{id?}', 'add_medicine')->name('pharmacy.add-medicine');
        Route::get('/medicine-lists', 'medicine_lists')->name('pharmacy.medicine-lists');
        Route::any('/update-medicine/{id?}', 'update_medicine')->name('pharmacy.update-medicine');
        Route::get('/add-medicine-billing', 'medicine_billing')->name('pharmacy.add-medicene-billing');

        Route::post('/get-medicines-by-category', 'getMedicinesByCategory')->name('pharmacy.get-medicines-by-category');
        Route::post('/get-medicine-by-composition', 'getMedicinesByComposition')->name('pharmacy.get-medicine-by-composition');


        Route::post('/save-pharmacy-billing', 'save_pharmacy_billing')->name('pharmacy.save-billing');
        Route::post('/update-pharmacy-billing', 'update_pharmacy_billing')->name('pharmacy.update-billing');

        Route::get('/medicine-billing-lists', 'medicine_billing_list')->name('pharmacy.medicine-billing-lists');
        Route::get('/edit-medicine-billing/{id?}', 'edit_medicine_billing')->name('pharmacy.edit-medicine-billing');
        Route::get('/med-print-bill/{bill_id?}', 'med_print_bill')->name('pharmacy.med-print-bill');


        Route::post('/update-stock', 'updateStock')->name('pharmacy.update-medicine-stock');
        Route::post('/refund-money', 'refundMedicineBilling')->name('pharmacy.refund-money');
    });

    Route::controller(MedInventoryController::class)->group(function () {

        Route::get('/create-purchase/{id?}', 'direct_puchase')->name('pharmacy.create-purchase');
        Route::post('/find-medicine-unit-by-medicine-name',  'find_medicine_name_by_medicine_name')->name('find-medicine-unit-by-medicine-name');
        Route::get('/purchase-lists', 'medicine_purchase_list')->name('pharmacy.purchase-lists');
        Route::any('/save-direct-purchase/{id?}', 'save_direct_purchase')->name('pharmacy.save-direct-purchase');
        Route::get('/medicine-purchase-details/{id?}', 'medicine_purchase_details')->name('pharmacy.medicine-purchase-details');
        Route::get('medicine-stock-update-from-purchase/{id?}', 'medicine_stock_update_from_purchase')->name('medicine-stock-update-from-purchase');

        Route::get('/add-requisition/{id?}', 'add_medicine_requisition_details')->name('pharmacy.add-requisition');
        Route::any('/update-requisition/{id?}', 'update_requisition')->name('pharmacy.update-requisition');
        Route::get('/requisition-lists', 'requisition_list')->name('pharmacy.requisition-lists');
        Route::get('/issue-lists', 'issue_list')->name('pharmacy.issue-lists');

        Route::get('/requisition-details/{id?}', 'all_medicine_requisition_details')->name('pharmacy.requisition-details');

        Route::get('/create-issue/{id?}', 'create_issue')->name('pharmacy.create-issue');
        Route::post('find-medicine-batch-by-medicine-name', 'find_medicine_batch_by_medicine_name')->name('find-medicine-batch-by-medicine-name');
        Route::post('find-medicine-details-by-medicine-batch', 'find_medicine_details_by_medicine_batch')->name('find-medicine-details-by-medicine-batch');
        Route::post('save-medicine-issue', 'save_medicine_issue')->name('pharmacy.save-medicine-issue');
        Route::get('/issue-report', 'issue_report')->name('pharmacy.issue-report');
        Route::get('/issue-details/{id?}', 'all_medicine_issue_details')->name('pharmacy.issue-details');
    });
});
