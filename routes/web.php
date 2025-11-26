<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\AuthController;

// DASHBOARD
use App\Http\Controllers\DashboardController;

// MASTER DATA
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PegawaiController;

// ABSEN
use App\Http\Controllers\AbsenController;

// IZIN SAKIT (ADMIN)
use App\Http\Controllers\Admin\IzinSakitController;



/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/post', [AuthController::class, 'authenticate'])->name('login.post');

});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Departemen
    |--------------------------------------------------------------------------
    */
    Route::get('/departemen', [DepartemenController::class, 'index'])->name('departemen.index');
    Route::get('/departemen/create', [DepartemenController::class, 'create'])->name('departemen.create');
    Route::post('/departemen/store', [DepartemenController::class, 'store'])->name('departemen.store');
    Route::get('/departemen/edit/{id}', [DepartemenController::class, 'edit'])->name('departemen.edit');
    Route::put('/departemen/update/{id}', [DepartemenController::class, 'update'])->name('departemen.update');
    Route::delete('/departemen/delete/{id}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');


    /*
    |--------------------------------------------------------------------------
    | Perusahaan
    |--------------------------------------------------------------------------
    */
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/perusahaan/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::get('/perusahaan/edit/{id}', [PerusahaanController::class, 'edit'])->name('perusahaan.edit');
    Route::post('/perusahaan/update/{id}', [PerusahaanController::class, 'update'])->name('perusahaan.update');
    Route::delete('/perusahaan/delete/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');


    /*
    |--------------------------------------------------------------------------
    | Pegawai
    |--------------------------------------------------------------------------
    */
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');


    /*
    |--------------------------------------------------------------------------
    | Absen
    |--------------------------------------------------------------------------
    */
    Route::get('/absen', [AbsenController::class, 'absen'])->name('admin.absen.index');
    Route::get('/absen/{id}', [AbsenController::class, 'show'])->name('admin.absen.show');


    /*
    |--------------------------------------------------------------------------
    | Izin Sakit (Admin)
    |--------------------------------------------------------------------------
    */
    Route::resource('izin', IzinSakitController::class);

    Route::post('izin/{id}/approve', [IzinSakitController::class, 'approve'])
        ->name('izin.approve');

    Route::post('izin/{id}/reject', [IzinSakitController::class, 'reject'])
        ->name('izin.reject');

});



/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])->group(function () {

    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

});
