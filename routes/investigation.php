<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Investigation\InvestigationController;
use App\Http\Controllers\Investigation\PrintController;

Route::middleware(['auth'])->prefix('investigation')->group(function () {
    Route::controller(InvestigationController::class)->group(function () {
        Route::get('/', 'index')->name('investigation.investigation');
        Route::get('/investigation-register', 'investigation_register')->name('investigation.investigation-register');
        Route::post('/update-investigation-register', 'update_investigation_register')->name('investigation.update-investigation-register');

        Route::get('/investigation-report/{type}/{value?}', 'investigation_report')->name('investigation.investigation-report');
        Route::post('/get-investigation-deatils', 'investigation_deatils')->name('investigation.investigation-deatils');
        Route::get('/report-upload/{id?}', 'report_upload')->name('investigation.report-upload');
        Route::post('/update-report', 'update_report')->name('investigation.update-report');

        // status update
        Route::get('/sample-collected/{id?}', 'sample_collected')->name('investigation.sample-collected');
        Route::post('/bulk-sample-collected', 'bulk_sample_collected')->name('investigation.bulk-sample-collected');
        Route::get('/lab-received/{id?}', 'lab_received')->name('investigation.lab-received');
        Route::post('/bulk-lab-received', 'bulk_lab_received')->name('investigation.bulk-lab-received');
        Route::get('/report-generate/{id?}', 'report_generate')->name('investigation.report-generate');
        Route::post('/bulk-report-generate', 'bulk_report_generate')->name('investigation.bulk-report-generate');
        Route::get('/report-deliverd/{id?}', 'report_deliverd')->name('investigation.report-deliverd');

        Route::get('/rate-query', 'rate_query')->name('investigation.rate-query');
        Route::get('/complete-investigation-report', 'complete_investigation_report')->name('investigation.ready-report');
    });
    Route::controller(PrintController::class)->group(function () {
        Route::get('/create-barcode/{id?}', 'create_barcode')->name('investigation.create-barcode');
        Route::get('/print-from-report-update/{id}', 'print_from_report_update')->name('investigation.print-from-report-update');
        Route::post('/print-clear-page','print_clear_page')->name('investigation.print-clear-page');
        Route::post('/print-bulk-reports','print_bulk_reports')->name('investigation.print-bulk-reports');
    });
});
