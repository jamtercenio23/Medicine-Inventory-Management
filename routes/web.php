<?php

use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\barangay\BarangayDistributionController;
use App\Http\Controllers\barangay\BarangayMedicineController;
use App\Http\Controllers\barangay\BarangayPatientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\MedicineController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\PatientController;
use App\Http\Controllers\admin\BarangayController;
use App\Http\Controllers\admin\DistributionController;
use App\Http\Controllers\admin\ScheduleController;
use App\Http\Controllers\admin\DistributionBarangayController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Admin Route
Route::middleware(['auth', 'is_active'])->group(function () {
    Route::group(['middleware' => 'permission:view-users'], function () {
        Route::resource('admin/users', UserController::class);
    });
    Route::group(['middleware' => 'permission:view-roles'], function () {
        Route::resource('admin/roles', RoleController::class);
    });
    Route::group(['middleware' => 'permission:view-permissions'], function () {
        Route::resource('admin/permissions', PermissionController::class);
    });
    Route::group(['middleware' => 'permission:view-medicines'], function () {
        Route::resource('admin/medicines', MedicineController::class);
        Route::get('/medicines/autocomplete', [MedicineController::class, 'autocomplete'])->name('medicines.autocomplete');
    });
    Route::group(['middleware' => 'permission:view-out-of-stock'], function () {
        Route::get('/medicines/out-of-stock/{medicine}/edit', [MedicineController::class, 'editOutOfStock'])->name('out-of-stock.edit');
        Route::put('/medicines/out-of-stock/{medicine}', [MedicineController::class, 'updateOutOfStock'])->name('out-of-stock.update');
        Route::get('/medicines/out-of-stock', [MedicineController::class, 'outOfStock'])->name('medicines.out-of-stock');
    });
    Route::group(['middleware' => 'permission:view-expired'], function () {
        Route::get('/medicines/expired', [MedicineController::class, 'expired'])->name('medicines.expired');
        Route::delete('/medicines/expired/{medicine}', [MedicineController::class, 'deleteExpired'])->name('medicines.delete-expired');
    });
    Route::group(['middleware' => 'permission:view-categories'], function () {
        Route::resource('admin/categories', CategoryController::class);
    });
    Route::group(['middleware' => 'permission:view-categories'], function () {
        Route::resource('admin/categories', CategoryController::class);
    });
    Route::group(['middleware' => 'permission:view-patients'], function () {
        Route::resource('admin/patients', PatientController::class);
        Route::get('/patients/autocomplete', [PatientController::class, 'autocomplete'])->name('patients.autocomplete');
    });
    Route::group(['middleware' => 'permission:view-barangays'], function () {
        Route::resource('admin/barangays', BarangayController::class);
    });
    Route::group(['middleware' => 'permission:view-schedules'], function () {
        Route::resource('admin/schedules', ScheduleController::class);
    });
    Route::group(['middleware' => 'permission:view-distributions'], function () {
        Route::resource('admin/distributions', DistributionController::class);
    });
    Route::group(['middleware' => 'permission:view-distribution-barangay'], function () {
        Route::resource('admin/distribution_barangay', DistributionBarangayController::class);
    });
    // Barangay Route
    Route::group(['middleware' => 'permission:view-barangay_medicines'], function () {
        Route::resource('barangay/barangay-medicines', BarangayMedicineController::class);
    });
    Route::group(['middleware' => 'permission:view-barangay_distributions'], function () {
        Route::resource('barangay/barangay-distributions', BarangayDistributionController::class);
    });
    Route::group(['middleware' => 'permission:view-barangay_patients'], function () {
        Route::resource('barangay/barangay-patients', BarangayPatientController::class);
    });

    // Generate Report Route
    // Medicines
    Route::post('/medicines/generate-medicine-report', [MedicineController::class, 'generateMedicineReport'])
        ->name('medicines.generateMedicineReport');
    Route::post('/medicines/generate-out-of-stock-report', [MedicineController::class, 'generateOutOfStockReport'])
        ->name('medicines.generateOutOfStockReport');
    Route::post('/medicines/generate-expired-report', [MedicineController::class, 'generateExpiredReport'])
        ->name('medicines.generateExpiredReport');
    // Patients
    Route::post('/patients/generate-patient-report', [PatientController::class, 'generatePatientReport'])
        ->name('patients.generatePatientReport');
    // Distributions
    Route::post('/distributions/generate-distribution-report', [DistributionController::class, 'generateDistributionReport'])
        ->name('distributions.generateDistributionReport');
    // DistributionBarangay
    Route::post('/distribution_barangay/generate-distribution-barangay-report', [DistributionBarangayController::class, 'generateDistributionBarangayReport'])
        ->name('distribution_barangay.generateDistributionBarangayReport');
    // BarangayDistribution
    Route::post('/barangay-distributions/generate-barangay-distribution-report', [BarangayDistributionController::class, 'generateBarangayDistributionReport'])
        ->name('barangay-distributions.generateBarangayDistributionReport');
    // BarangayMedicine
    Route::post('/barangay-medicines/generate-barangay-medicine-report', [BarangayMedicineController::class, 'generateBarangayMedicineReport'])
        ->name('barangay-medicines.generateBarangayMedicineReport');
    // BarangayPatient
    Route::post('/barangay-patients/generate-barangay-patient-report', [BarangayPatientController::class, 'generateBarangayPatientReport'])
        ->name('barangay-patients.generateBarangayPatientReport');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});
