<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleUsageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RedirectController;


Route::get('/', function () {
    return view('login');
});

// Authentication routes
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('/proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Routes accessible to authenticated users
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role_id:1'])->group(function () {
        // Admin-specific routes
        Route::get('dashboardAdmin', [DashboardController::class, 'indexAdmin'])->name('dashboardAdmin');
        // Admin-specific reservation management routes



        Route::get('adminku/reservation/index', [ReservationController::class, 'indexAdmin'])->name('adminku.reservation.index');
        Route::get('adminku/reservation/{id}/edit', [ReservationController::class, 'editAdmin'])->name('adminku.reservation.edit');
        Route::put('adminku/reservation/{id}', [ReservationController::class, 'updateAdmin'])->name('adminku.reservation.update');
        Route::delete('/admin/reservations/{reservation}', [ReservationController::class, 'destroyAdmin'])->name('adminku.reservation.delete');
        // Menampilkan form untuk pemesanan baru
        Route::get('adminku/reservation/create', [ReservationController::class, 'createAdmin'])->name('adminku.reservation.create');
        Route::get('adminku/reservation/report', [ReservationController::class, 'exportReport'])->name('adminku.reservation.report');

        // Menyimpan pemesanan baru
        Route::post('adminku/reservation', [ReservationController::class, 'storeadmin'])->name('adminku.reservation.store');
        // Menyetujui pemesanan level 1
        Route::post('adminku/reservation/{id}/approve-level1', [ReservationController::class, 'approveLevel1Admin'])->name('adminku.reservation.approveLevel1');
        // Menyetujui pemesanan level 2
        Route::post('adminku/reservation/{id}/approve-level2', [ReservationController::class, 'approveLevel2Admin'])->name('adminku.reservation.approveLevel2');
        // Menolak pemesanan
        Route::post('adminku/reservation/{id}/reject', [ReservationController::class, 'rejectAdmin'])->name('adminku.reservation.reject');

        Route::get('adminku/vehicles', [VehicleController::class, 'indexAdmin'])->name('adminku.vehicles.index');   
        Route::get('adminku/vehicles/create', [VehicleController::class, 'createAdmin'])->name('adminku.vehicles.create'); 
        Route::post('adminku/vehicles', [VehicleController::class, 'storeAdmin'])->name('adminku.vehicles.store');  
         Route::get('adminku/vehicles/{vehicle}/edit', [VehicleController::class, 'editAdmin'])->name('adminku.vehicles.edit');
        Route::put('adminku/vehicles/{vehicle}', [VehicleController::class, 'updateAdmin'])->name('adminku.vehicles.update');   
         Route::delete('adminku/vehicles/{vehicle}', [VehicleController::class, 'destroyAdmin'])->name('adminku.vehicles.destroy');
         Route::get('adminku/vehicles/export', [VehicleController::class, 'exportToExcel'])->name('adminku.vehicles.export');


         Route::get('adminku/vehicleusage/index', [VehicleUsageController::class, 'indexAdmin'])->name('adminku.vehicleusage.index');
         Route::get('adminku/vehicleusage/create', [VehicleUsageController::class, 'createAdmin'])->name('adminku.vehicleusage.create');
         Route::post('adminku/vehicleusage', [VehicleUsageController::class, 'storeAdmin'])->name('adminku.vehicleusage.store');
         Route::get('adminku/vehicleusage/{id}/edit', [VehicleUsageController::class, 'editAdmin'])->name('adminku.vehicleusage.edit');
         Route::put('adminku/vehicleusage/{id}/update', [VehicleUsageController::class, 'updateAdmin'])->name('adminku.vehicleusage.update');
         Route::delete('adminku/vehicleusage/index{id}', [VehicleUsageController::class, 'destroyAdmin'])->name('adminku.vehicleusage.destroy');
         Route::get('adminku/vehicleusage/export', [VehicleUsageController::class, 'exportAdmin'])->name('adminku.vehicleusage.export');

     
     });
    });


    Route::middleware(['role_id:2'])->group(function () {
        // Approval-specific routes
        Route::get('dashboardApproval', [DashboardController::class, 'indexApproval'])->name('dashboardApproval');

        Route::get('Approval/reservation/index', [ReservationController::class, 'indexApproval'])->name('Approval.reservation.index');
        Route::post('Approval/reservation/{id}/approve-level1', [ReservationController::class, 'approveLevel1Approval'])->name('Approval.reservation.approveLevel1');
        Route::post('Approval/reservation/{id}/approve-level2', [ReservationController::class, 'approveLevel2Approval'])->name('Approval.reservation.approveLevel2');
        Route::post('Approval/reservation/{id}/reject', [ReservationController::class, 'rejectApproval'])->name('Approval.reservation.reject');
        Route::get('Approval/reservation/report', [ReservationController::class, 'exportReport'])->name('Approval.reservation.report');

        Route::get('Approval/vehicles', [VehicleController::class, 'indexApproval'])->name('Approval.vehicles.index');    
        Route::get('Approval/vehicles/{vehicle}/edit', [VehicleController::class, 'editApproval'])->name('Approval.vehicles.edit'); 
        Route::put('Approval/vehicles/{vehicle}', [VehicleController::class, 'updateApproval'])->name('Approval.vehicles.update');   
        Route::delete('Approval/vehicles/{vehicle}', [VehicleController::class, 'destroyApproval'])->name('Approval.vehicles.destroy');
        Route::get('Approval/vehicles/export', [VehicleController::class, 'exportToExcel'])->name('Approval.vehicles.export');

        Route::get('Approval/vehicleusage/index', [VehicleUsageController::class, 'indexApproval'])->name('Approval.vehicleusage.index');
        Route::get('Approval/vehicleusage/{id}/edit', [VehicleUsageController::class, 'editApproval'])->name('Approval.vehicleusage.edit');
        Route::put('Approval/vehicleusage/{id}/update', [VehicleUsageController::class, 'updateApproval'])->name('Approval.vehicleusage.update');
        Route::get('Approval/vehicleusage/export', [VehicleUsageController::class, 'exportAdmin'])->name('Approval.vehicleusage.export');


        
    });

    // Superadmin and employee specific routes
    Route::group(['middleware' => ['auth', 'checkrole:1,2']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/redirect', [RedirectController::class, 'cek']);
    });

Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']); 
    Route::get('{id}', [VehicleController::class, 'show']); 
    Route::post('/', [VehicleController::class, 'store']);
    Route::put('{id}', [VehicleController::class, 'update']); 
    Route::delete('{id}', [VehicleController::class, 'destroy']); 
});