<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Optical\OpticalController;
use App\Http\Controllers\Optical\RequisitionController;
use App\Http\Controllers\Optical\PurchaseController;
use App\Http\Controllers\Optical\POController;
use App\Http\Controllers\Optical\IssueController;

Route::middleware(['auth'])->prefix('optical')->group(function () {
    Route::controller(OpticalController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('optical.dashboard');

        //Item
        Route::get('/item-info/{id?}', 'item_info')->name('optical.item-info');
        Route::get('/listing-item', 'listing_item')->name('optical.listing-item');
        Route::get('/add-item', 'add_item')->name('optical.add-item');
        Route::get('/edit-item/{id?}', 'edit_item')->name('optical.edit-item');
        Route::post('/update-item/{id?}', 'update_item')->name('optical.update-item');
        Route::get('/delete-item/{id?}', 'delete_item')->name('optical.delete-item');

        //Item Subcategory
        Route::get('/get-subcategories/{id?}', 'get_subcategories')->name('optical.get-subcategories');

        //Item Type
        Route::get('/item-type', 'item_type')->name('optical.item-type');
        Route::get('/edit-item-type/{id?}', 'edit_item_type')->name('optical.edit-item-type');
        Route::post('/update-item-type/{id?}', 'update_item_type')->name('optical.update-item-type');

        //Company
        Route::get('/item-brand', 'item_brand')->name('optical.item-brand');
        Route::get('/edit-item-brand/{id?}', 'edit_item_brand')->name('optical.edit-item-brand');
        Route::post('/update-item-brand/{id?}', 'update_item_brand')->name('optical.update-item-brand');

        //Unit
        Route::get('/item-unit', 'item_unit')->name('optical.item-unit');
        Route::get('/edit-item-unit/{id?}', 'edit_item_unit')->name('optical.edit-item-unit');
        Route::post('/update-item-unit/{id?}', 'update_item_unit')->name('optical.update-item-unit');

        //optical Department
        Route::get('/optical-department', 'optical_department')->name('optical.optical-department');
        Route::get('/edit-optical-department/{id?}', 'edit_optical_department')->name('optical.edit-optical-department');
        Route::post('/update-optical-department/{id?}', 'update_optical_department')->name('optical.update-optical-department');

        // //Item optical Room
        // Route::get('/item-store-room', 'item_store')->name('optical.item-store');
        // Route::get('/edit-item-store-room/{id?}', 'edit_item_store')->name('optical.edit-item-store');
        // Route::post('/update-item-store-room/{id?}', 'update_item_store')->name('optical.update-item-store');

        //Item Category
        Route::get('/item-catagory', 'item_catagory')->name('optical.item-catagory');
        Route::get('/edit-item-catagory/{id?}', 'edit_item_catagory')->name('optical.edit-item-catagory');
        Route::post('/update-item-catagory/{id?}', 'update_item_catagory')->name('optical.update-item-catagory');
        Route::get('/get-categories', 'parent_categories')->name('optical.categories');
        Route::get('/get-sub-categories/{id?}', 'sub_categories')->name('optical.sub-categories');

        //Vendor
        Route::get('/listing-vendor', 'listing_vendor')->name('optical.listing-vendor');
        Route::get('/add-vendor', 'add_vendor')->name('optical.add-vendor');
        Route::get('/edit-vendor/{id?}', 'edit_vendor')->name('optical.edit-vendor');
        Route::post('/update-vendor/{id?}', 'update_vendor')->name('optical.update-vendor');

        Route::post('/get-item-unit-and-sub-unit', 'getUnitDetails')->name('optical.get-item-unit-and-sub-unit');
        Route::post('/get-batch-details', 'getBatchDetails')->name('optical.get-batch-details');
        Route::post('/get-product-details', 'getProductDetails')->name('optical.get-product-details');
    });
    Route::controller(RequisitionController::class)->group(function () {
        //Requisition
        Route::get('/listing-requisition', 'listing_requisition')->name('optical.listing-requisition');
        Route::get('/add-requisition', 'add_requisition')->name('optical.add-requisition');
        Route::get('/edit-requisition/{id?}', 'edit_requisition')->name('optical.edit-requisition');
        Route::post('/update-requisition/{id?}', 'update_requisition')->name('optical.update-requisition');
        Route::get('/requisition-info/{id?}', 'requisition_details')->name('optical.requisition-details');
        Route::get('/delete-requisition/{id?}', 'delete_requisition')->name('optical.delete-requisition');
    });
    Route::controller(POController::class)->group(function () {
        //PO
        Route::get('/listing-purchase-order', 'listing_purchase_order')->name('optical.listing-purchase-order');
        Route::get('/add-purchase-order', 'add_purchase_order')->name('optical.add-purchase-order');
        Route::get('/edit-purchase-order/{id?}', 'edit_purchase_order')->name('optical.edit-purchase-order');
        Route::post('/update-purchase-order/{id?}', 'update_purchase_order')->name('optical.update-purchase-order');
        Route::get('/purchase-order-info/{id?}', 'purchase_order_details')->name('optical.purchase-order-details');
        Route::get('/delete-purchase-order/{id?}', 'delete_purchase_order')->name('optical.delete-purchase-order');
        Route::post('/get-po-details', 'get_po_details')->name('optical.get-po-details');
    });
    Route::controller(PurchaseController::class)->group(function () {
        //Purchase
        Route::get('/listing-purchase', 'listing_purchase')->name('optical.listing-purchase');
        Route::get('/add-purchase', 'add_purchase')->name('optical.add-purchase');
        Route::get('/edit-purchase/{id?}', 'edit_purchase')->name('optical.edit-purchase');
        Route::post('/update-purchase/{id?}', 'update_purchase')->name('optical.update-purchase');
        Route::get('/purchase-info/{id?}', 'purchase_details')->name('optical.purchase-details');
        Route::get('/delete-purchase/{id?}', 'delete_purchase')->name('optical.delete-purchase');
    });
    Route::controller(IssueController::class)->group(function () {
        // Optical Billing
        Route::get('/optical-billing', 'optical_billing')->name('optical.optical-billing');
        Route::get('/add-billing', 'add_billing')->name('optical.add-billing');
        Route::get('/edit-billing/{id}', 'edit_optical_billing')->name('optical.edit-billing');
        Route::get('/billing-details', 'optical_billing_details')->name('optical.billing-details');
        Route::post('/update-billing', 'update_billing')->name('optical.update-billing');
        Route::post('/available-item-qty', 'available_item_qty')->name('optical.available-item-qty');

        // Eye Examination
        Route::get('/vision-care', 'eye_examination')->name('optical.eye-examination');
        Route::get('/eye-exam-info/{id}', 'eye_exam_info')->name('optical.eye-exam-info');
        Route::get('/delete-eye-exam/{id}', 'delete_eye_exam')->name('optical.delete-eye-exam');
        Route::get('/register-examination', 'register_examination')->name('optical.register-examination');
        Route::post('/optical-register', 'optical_register')->name('optical.optical-register');
        Route::post('/update-examination', 'update_examination')->name('optical.update-examination');
        Route::get('/view-examination/{id}', 'view_examination')->name('optical.view-examination');

        // Eye Surgery Planning
        Route::get('/surgery-planning', 'surgery_planning')->name('optical.surgery-planning');
        Route::get('/surgery-planning-details/{id}', 'surgery_planning_details')->name('optical.surgery-planning-details');
        Route::get('/register-surgery-planning', 'register_surgery_planning')->name('optical.register-surgery-planning');
        Route::post('/update-surgery-planning/{id?}', 'update_surgery_planning')->name('optical.update-surgery-planning');
        Route::post('/update-surgery/{id}', 'update_surgery')->name('optical.update-surgery');

        // eye lens
        Route::get('/update-eye-lens/{sec_id}', 'update_eye_lens')->name('optical.update-eye-lens');
        Route::post('/update-eye-power/{sec_id?}/{id?}', 'update_eye_power')->name('optical.update-eye-power');
        Route::get('/print-eye-power/{sec_id}/{header}', 'print_eye_power')->name('optical.print-eye-power');
    });
});
