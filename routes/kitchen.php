<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kitchen\KitchenController;
use App\Http\Controllers\Kitchen\RequisitionController;
use App\Http\Controllers\Kitchen\POController;
use App\Http\Controllers\Kitchen\PurchaseController;
use App\Http\Controllers\Kitchen\OrderController;

Route::middleware(['auth'])->prefix('kitchen')->group(function () {
    Route::controller(KitchenController::class)->group(function () {
        // expenses & stock
        Route::get('/present-stock', 'present_stock')->name('kt.present-stock');
        Route::get('/daily-expenses', 'daily_expenses')->name('kt.daily-expenses');
        Route::get('/add-daily-expenses', 'add_daily_expenses')->name('kt.add-daily-expenses');
        Route::get('/edit-daily-expenses/{id?}', 'edit_daily_expenses')->name('kt.edit-daily-expenses');
        Route::post('/update-daily-expenses/{id?}', 'update_daily_expenses')->name('kt.update-daily-expenses');
        Route::get('/daily-expenses-info/{id?}', 'daily_expenses_details')->name('kt.daily-expenses-details');
        Route::get('/delete-daily-expenses/{id?}', 'delete_daily_expenses')->name('kt.delete-daily-expenses');

        // Diet Charts Assign
        Route::get('/diet-patients', 'diet_patients')->name('kt.diet-patients');
        Route::get('/diet-charts-assign', 'diet_charts_assign')->name('kt.diet-charts-assign');
        Route::get('/edit-charts-assign/{id}', 'edit_charts_assign')->name('kt.edit-charts-assign');
        Route::get('/delete-charts-assign/{id}', 'delete_charts_assign')->name('kt.delete-charts-assign');
        Route::post('/update-charts-assign/{id?}', 'update_charts_assign')->name('kt.update-charts_assign');
        Route::post('/get-diet-info', 'get_diet_info')->name('kt.get-diet-info');

        // Meal Item
        Route::get('/meal-items', 'meal_items')->name('kt.meal-items');
        Route::get('/edit-meal-items/{id?}', 'edit_meal_items')->name('kt.edit-meal-items');
        Route::post('/update-meal-items/{id?}', 'update_meal_items')->name('kt.update-meal-items');

        // Diet Meal
        Route::any('/diet-meal', 'diet_meal')->name('kt.diet-meal');
        Route::post('/update-diet-meal/{id}', 'update_diet_meal')->name('kt.update-diet-meal');

        // Diet Types
        Route::get('/diet-types', 'diet_types')->name('kt.diet-types');
        Route::get('/edit-diet-types/{id?}', 'edit_diet_types')->name('kt.edit-diet-types');
        Route::post('/update-diet-types/{id?}', 'update_diet_types')->name('kt.update-diet-types');

        // Items
        Route::get('/items', 'items')->name('kt.items');
        Route::get('/item-info/{id?}', 'item_info')->name('kt.item-info');
        Route::get('/edit-item/{id?}', 'edit_item')->name('kt.edit-item');
        Route::post('/update-item/{id?}', 'update_item')->name('kt.update-item');
        Route::post('/item-unit', 'item_unit')->name('kt.item-unit');
        Route::post('/get-item-unit', 'get_item_unit')->name('kt.get-item-unit');

        // category
        Route::get('/categories', 'categories')->name('kt.categories');
        Route::get('/edit-category/{id?}', 'edit_category')->name('kt.edit-category');
        Route::post('/update-category/{id?}', 'update_category')->name('kt.update-category');

        // Unit
        Route::get('/units', 'units')->name('kt.units');
        Route::get('/edit-unit/{id?}', 'edit_unit')->name('kt.edit-unit');
        Route::post('/update-unit/{id?}', 'update_unit')->name('kt.update-unit');

        // Suppliers
        Route::get('/suppliers', 'suppliers')->name('kt.suppliers');
        Route::get('/edit-supplier/{id?}', 'edit_supplier')->name('kt.edit-supplier');
        Route::post('/update-supplier/{id?}', 'update_supplier')->name('kt.update-supplier');
    });
    Route::controller(RequisitionController::class)->group(function () {
        //Requisition
        Route::get('/requisitions', 'index')->name('kt.requisitions');
        Route::get('/add-requisition', 'add_requisition')->name('kt.add-requisition');
        Route::get('/edit-requisition/{id?}', 'edit_requisition')->name('kt.edit-requisition');
        Route::post('/update-requisition/{id?}', 'update_requisition')->name('kt.update-requisition');
        Route::get('/requisition-info/{id?}', 'requisition_details')->name('kt.requisition-details');
        Route::get('/delete-requisition/{id?}', 'delete_requisition')->name('kt.delete-requisition');
    });
    Route::controller(POController::class)->group(function () {
        //PO
        Route::get('/purchase-orders', 'index')->name('kt.purchase-orders');
        Route::get('/add-purchase-order', 'add_purchase_order')->name('kt.add-purchase-order');
        Route::get('/edit-purchase-order/{id?}', 'edit_purchase_order')->name('kt.edit-purchase-order');
        Route::post('/update-purchase-order/{id?}', 'update_purchase_order')->name('kt.update-purchase-order');
        Route::get('/purchase-order-info/{id?}', 'purchase_order_details')->name('kt.purchase-order-details');
        Route::get('/delete-purchase-order/{id?}', 'delete_purchase_order')->name('kt.delete-purchase-order');
    });
    Route::controller(PurchaseController::class)->group(function () {
        //Purchase
        Route::get('/purchase', 'index')->name('kt.purchase');
        Route::get('/add-purchase', 'add_purchase')->name('kt.add-purchase');
        Route::get('/edit-purchase/{id?}', 'edit_purchase')->name('kt.edit-purchase');
        Route::post('/update-purchase/{id?}', 'update_purchase')->name('kt.update-purchase');
        Route::get('/purchase-info/{id?}', 'purchase_details')->name('kt.purchase-details');
        Route::get('/delete-purchase/{id?}', 'delete_purchase')->name('kt.delete-purchase');
    });
    Route::controller(OrderController::class)->group(function () {
        //orders
        Route::get('/manage-orders', 'manage_orders')->name('kt.manage-orders');
        Route::get('/due-collection/{id}', 'due_collection')->name('kt.due-collection');
        Route::get('/food-delivery', 'food_delivery')->name('kt.food-delivery');
        Route::post('/update-delivery', 'update_delivery')->name('kt.update-delivery');
        Route::post('/update-multi-delivery', 'update_multi_delivery')->name('kt.update-multi-delivery');
        Route::get('/orders-report', 'orders_report')->name('kt.orders-report');

        Route::post('/meal-price', 'meal_price')->name('kt.meal-price');
        Route::post('/save-orders', 'save_orders')->name('kt.save-orders');
    });
});
