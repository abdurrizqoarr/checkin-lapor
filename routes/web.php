<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportLogsControllers;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

Route::get('/point-checkin/{id}', [PointController::class, 'checkinPage'])->name('point.checkin');
Route::get('/generate-qr/{id}', [PointController::class, 'generateLinkDanQr'])->name('point.generateQr');
Route::post('/lapor-checkin', [PointController::class, 'checkin'])->name('point.laporCheckin');

Route::get('/', [HomeContoller::class, 'loginPage'])->name('login');
Route::post('/', [HomeContoller::class, 'handleLogin'])->name('handleLogin');
Route::post('/logout', [HomeContoller::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeContoller::class, 'dashboard'])->name('dashboard');

Route::get('/login-admin', [AdminController::class, 'loginPageAdmin'])->name('login-admin');
Route::post('/login-admin', [AdminController::class, 'handleLoginPageAdmin'])->name('handleLogin-admin');

Route::get('/dashboard-admin', [AdminController::class, 'dashboardAdmin'])->name('dashboard-admin');

Route::get('/dashboard-admin/export', [ExportLogsControllers::class, 'exportPage'])->name('export-logs');
Route::post('/dashboard-admin/export', [ExportLogsControllers::class, 'handleExport'])->name('handle-export-logs');

Route::get('/lokasi', [AdminController::class, 'lokasiQR'])->name('lokasi.page');
Route::get('/add-lokasi', [AdminController::class, 'addLokasi'])->name('lokasi.create');
Route::get('/edit-lokasi', [AdminController::class, 'editLokasi'])->name('lokasi.edit');
Route::get('/delete-lokasi', [AdminController::class, 'deleteLokasi'])->name('lokasi.delete');
