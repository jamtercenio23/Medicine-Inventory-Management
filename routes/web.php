<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DistributionBarangayController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('admin/medicines', MedicineController::class);
    Route::get('/medicines/out-of-stock/{medicine}/edit', [MedicineController::class, 'editOutOfStock'])->name('out-of-stock.edit');
    Route::put('/medicines/out-of-stock/{medicine}', [MedicineController::class, 'updateOutOfStock'])->name('out-of-stock.update');
    Route::get('/medicines/out-of-stock', [MedicineController::class, 'outOfStock'])->name('medicines.out-of-stock');
    Route::get('/medicines/expired', [MedicineController::class, 'expired'])->name('medicines.expired');
    Route::delete('/medicines/expired/{medicine}', [MedicineController::class, 'deleteExpired'])->name('medicines.delete-expired');
    Route::resource('admin/categories', CategoryController::class);

    Route::resource('admin/patients', PatientController::class);

    Route::resource('admin/barangays', BarangayController::class);

    Route::resource('admin/schedules', ScheduleController::class);

    Route::resource('admin/distributions', DistributionController::class);
    Route::resource('admin/distribution-barangay', DistributionBarangayController::class);

});
