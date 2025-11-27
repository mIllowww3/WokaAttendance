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
use App\Http\Controllers\JadwalKerjaController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/post', [AuthController::class, 'authenticate'])->name('login.post');

});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    Route::get('/departemen', [DepartemenController::class, 'index'])->name('departemen.index');
    Route::get('/departemen/create', [DepartemenController::class, 'create'])->name('departemen.create');
    Route::post('/departemen/store', [DepartemenController::class, 'store'])->name('departemen.store');
    Route::get('/departemen/edit/{id}', [DepartemenController::class, 'edit'])->name('departemen.edit');
    Route::put('/departemen/update/{id}', [DepartemenController::class, 'update'])->name('departemen.update');
    Route::delete('/departemen/delete/{id}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');

    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/perusahaan/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::get('/perusahaan/edit/{id}', [PerusahaanController::class, 'edit'])->name('perusahaan.edit');
    Route::post('/perusahaan/update/{id}', [PerusahaanController::class, 'update'])->name('perusahaan.update');
    Route::delete('/perusahaan/delete/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/absen', [AbsenController::class, 'absen'])->name('absen.index');
    Route::get('/absen/{id}', [AbsenController::class, 'show'])->name('absen.show');
    Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');

    Route::resource('jadwal', JadwalKerjaController::class);

    Route::resource('izin', IzinSakitController::class);
    Route::post('izin/{id}/approve', [IzinSakitController::class, 'approve'])->name('izin.approve');
    Route::post('izin/{id}/reject', [IzinSakitController::class, 'reject'])->name('izin.reject');

});

Route::middleware(['auth','role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staff'])->name('dashboard');

    Route::get('/profile', [PegawaiController::class, 'profile'])->name('profile.index');
    Route::put('/profile/update/{id}', [PegawaiController::class, 'profileUpdate'])->name('profile.update');

    Route::get('izin', [IzinSakitController::class, 'staffIndex'])->name('izin.index');
    Route::get('izin/create', [IzinSakitController::class, 'staffCreate'])->name('izin.create');
    Route::post('izin/store', [IzinSakitController::class, 'staffStore'])->name('izin.store');
    Route::get('izin/show/{id}', [IzinSakitController::class, 'staffShow'])->name('izin.show');
    Route::get('izin/edit/{id}', [IzinSakitController::class, 'staffEdit'])->name('izin.edit');
    Route::delete('/delete/{id}', [IzinSakitController::class, 'destroy'])->name('izin.destroy');
    Route::put('izin/update/{id}', [IzinSakitController::class, 'staffUpdate'])->name('izin.update');



});

    