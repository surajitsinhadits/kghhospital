<?php

use App\Http\Controllers\BloodBank\BloodBankController;
use App\Http\Controllers\IVF\IvfController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('ivf')->group(function () {
    Route::get('/ivf-couple-list', [IvfController::class, 'ivf_couple_list'])->name('ivf.ivf-couple-list');
    Route::get('/ivf-couple-registration', [IvfController::class, 'ivf_couple_registration'])->name('ivf.couple-registration');
    Route::get('/ivf-couple-registration/{id}', [IvfController::class, 'edit_couple_registration'])->name('ivf.edit-couple-registration');
    Route::post('/ivf-male-doner', [IvfController::class, 'ivf_male_doner'])->name('ivf.male-doner');
    Route::post('/ivf-female-doner', [IvfController::class, 'ivf_female_doner'])->name('ivf.female-doner');
    Route::post('/ivf-couple-registration-save', [IvfController::class, 'ivf_couple_registration_save'])->name('ivf.couple-registration-save');
});
