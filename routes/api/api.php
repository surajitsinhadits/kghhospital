<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiReportController;
use App\Http\Controllers\Api\MiscellaneousApiController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Middleware\LogApiCalls;

Route::get('/backup-db', [ApiController::class, 'backup']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/patientLogin', [LoginController::class, 'patient_login']);
Route::get('/miscellanies', [MiscellaneousApiController::class, 'index']);
Route::post('/miscellanies', [MiscellaneousApiController::class, 'store']);
Route::get('/miscellanies/complete/{id}', [MiscellaneousApiController::class, 'complete'])->whereNumber('id');
Route::get('/miscellanies/{id}', [MiscellaneousApiController::class, 'index'])->whereNumber('id');



Route::get('/dashboard', [ApiReportController::class, 'dashboard']);

Route::get('get-filteration-data', [ApiReportController::class, 'get_filteration_for_billing']);
Route::post('billing-reports', [ApiReportController::class, 'billing_reports_api']);

Route::get('get-filteration-ipd-report', [ApiReportController::class, 'filteration_for_ipd_report']);
Route::post('ipd-report', [ApiReportController::class, 'ipd_reports_api']);
Route::post('dialysis-report', [ApiReportController::class, 'dialysis_reports_api']);


Route::post('birth-report', [ApiReportController::class, 'birth_report_api']);
Route::post('death-report', [ApiReportController::class, 'death_report_api']);
Route::post('discharge-report', [ApiReportController::class, 'discharge_report_api']);


Route::get('get-filteration-report', [ApiReportController::class, 'filteration_for_report']);
Route::post('opd-billing-reports', [ApiReportController::class, 'opd_reports_api']);
Route::post('emg-report', [ApiReportController::class, 'emg_reports_api']);
Route::post('approvalsystem/{section?}', [ApiReportController::class, 'approval_system']);
Route::get('approve/{id}', [ApiReportController::class, 'approve']);
Route::get('approvalList/{id}', [ApiReportController::class, 'approved_list']);
Route::get('approval-list-count', [ApiReportController::class, 'approval_list_count']);
Route::get('billing-details/{section_id}/{bill_id}', [ApiReportController::class, 'billing_details']);
Route::post('collection-report', [ApiReportController::class, 'collection']);
Route::post('users-collection', [ApiReportController::class, 'users_collection']);
Route::post('doctor-payout', [ApiReportController::class, 'doctor_payout']);
Route::post('doctor-payout-details/{id}/{date}', [ApiReportController::class, 'doctor_payout_info']);

Route::middleware(['auth:sanctum', LogApiCalls::class])->group(function () {

    Route::post('/appointments', [PatientController::class, 'appointments']);
    Route::post('/patient_all_bills', [PatientController::class, 'get_patient_all_bill']);
    Route::get('/get_doctor', [PatientController::class, 'get_doctors']);
    Route::get('/patient_details', [PatientController::class, 'patient_details']);
    Route::get('/department_list', [PatientController::class, 'department_list']);
    Route::post('/get_doctors_by_dept', [PatientController::class, 'get_doctors_by_dept']);
    Route::post('/get_schedule', [PatientController::class, 'get_schedule']);
    Route::post('/get_timeslot', [PatientController::class, 'get_timeslot']);
    Route::get('/rate_query', [PatientController::class, 'rate_query']);
    Route::post('/complete_investigation_report', [PatientController::class, 'complete_investigation_report']);
});


// Route::middleware('auth:sanctum')->group(function () {
//     // Route::get('/user', function () {
//     //     return response()->json(auth()->user());
//     // });
//     Route::get('/get_appointment', [ApiController::class, 'get_appointment'])->name('api.get_appointment');
//     Route::controller(ApiController::class)->group(function () {
//     Route::get('/user_list', 'user_list');
//     Route::post('/user_details  ', 'user_details');
//     Route::post('/user_active_deactive', 'user_active_deactive');
//     Route::get('/notices', 'notices');
//     Route::post('/save_notice', 'save_notice');
//     Route::post('/edit_notice', 'edit_notice');
//     Route::post('/update_notice', 'update_notice');
//     Route::post('/delete_notice', 'delete_notice');
//     Route::get('/events', 'events');
//     Route::post('/save_event', 'save_event');
//     Route::post('/edit_event', 'edit_event');
//     Route::post('/update_event', 'update_event');
//     Route::post('/delete_event', 'delete_event');
//     // payslip
//     Route::post('/payslip_list_for_hr', 'payslip_list_for_hr');
//     Route::get('/download-payslip/{id}', 'downloadPayslip');

//     });
// });
