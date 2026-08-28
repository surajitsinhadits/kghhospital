<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payroll\PayrollMasterController;
use App\Http\Controllers\Payroll\PayrollController;


Route::middleware(['auth'])->prefix('payroll')->group(function () {
    Route::controller(PayrollMasterController::class)->group(function () {
        // Salary Master
        Route::get('/salary-master', 'salary_master')->name('payroll.salary-master');
        Route::get('/edit-salary-master/{id?}', 'edit_salary_master')->name('payroll.edit-salary-master');
        Route::post('/update-salary-master/{id?}', 'update_salary_master')->name('payroll.update-salary-master');

        // Salary Type
        Route::get('/salary-type', 'salary_type')->name('payroll.salary-type');
        Route::get('/edit-salary-type/{id?}', 'edit_salary_type')->name('payroll.edit-salary-type');
        Route::post('/update-salary-type/{id?}', 'update_salary_type')->name('payroll.update-salary-type');
        // Rules Formula
        Route::get('/salary-rule/{salary_type_id?}', 'salary_rule')->name('payroll.salary-rule');
        Route::get('/edit-salary-rule/{id?}', 'edit_salary_rule')->name('payroll.edit-salary-rule');
        Route::post('/update-salary-rule/{salary_type_id?}/{id?}', 'update_salary_rule')->name('payroll.update-salary-rule');
        // Structure Formula
        Route::get('/salary-structure/{salary_master_id?}', 'salary_structure')->name('payroll.salary-structure');
        Route::get('/edit-salary-structure/{id?}', 'edit_salary_structure')->name('payroll.edit-salary-structure');
        Route::post('/update-salary-structure/{salary_master_id?}/{id?}', 'update_salary_structure')->name('payroll.update-salary-structure');
    });
    Route::controller(PayrollController::class)->group(function () {
        // Get Salary rules
        Route::get('/get-salary-rules-by-type/{salary_type_id?}', 'salary_structure_by_type_id')->name('payroll.get-salary-rules-by-type');
        // User Generate Payroll
        Route::get('/user-generate-payroll', 'user_generate_payroll')->name('payroll.user-generate-payroll');
        // Salary generate
        Route::get('/process-salary', 'processSalary')->name('payroll.process_salary');
        Route::get('/generate-salary', 'generate_salary')->name('payroll.generate_salary');
        Route::get('/get-generated-salary/{user_id?}', 'get_generated_salary')->name('payroll.get-generated-salary');
    });
});