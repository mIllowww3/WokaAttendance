<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/post', [AuthController::class, 'authenticate'])->name('login.post');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // CRUD Departemen
    Route::get('/departemen', [DepartemenController::class, 'index'])->name('departemen.index');
    Route::get('/departemen/create', [DepartemenController::class, 'create'])->name('departemen.create');
    Route::post('/departemen/store', [DepartemenController::class, 'store'])->name('departemen.store');
    Route::get('/departemen/edit/{id}', [DepartemenController::class, 'edit'])->name('departemen.edit');
    Route::put('/departemen/update/{id}', [DepartemenController::class, 'update'])->name('departemen.update');
    Route::delete('/departemen/delete/{id}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');

    // CRUD Perusahaan
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/perusahaan/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::get('/perusahaan/edit/{id}', [PerusahaanController::class, 'edit'])->name('perusahaan.edit');
    Route::post('/perusahaan/update/{id}', [PerusahaanController::class, 'update'])->name('perusahaan.update');
    Route::delete('/perusahaan/delete/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');

    // CRUD Pegawai
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/absen', [AbsenController::class, 'absen'])->name('admin.absen.index');
    Route::get('/absen/{id}', [AbsenController::class, 'show'])->name('admin.absen.show');

    Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');

    // CRUD Jadwal Kerja
    Route::get('/jadwal', [JadwalKerjaController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create', [JadwalKerjaController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal/store', [JadwalKerjaController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/edit/{id}', [JadwalKerjaController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/update/{id}', [JadwalKerjaController::class, 'update'])->name('jadwal.update'); 
    Route::delete('/jadwal/delete/{id}', [JadwalKerjaController::class, 'destroy'])->name('jadwal.destroy');
});

Route::middleware(['auth','role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staff'])->name('staff.dashboard');

});
