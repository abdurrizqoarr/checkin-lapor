<?php

use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

Route::get('/point-checkin/{id}', [PointController::class, 'checkinPage'])->name('point.checkin');
Route::post('/lapor-checkin', [PointController::class, 'checkin'])->name('point.laporCheckin');

Route::get('/', [HomeContoller::class, 'loginPage'])->name('login');
Route::post('/', [HomeContoller::class, 'handleLogin'])->name('handleLogin');
Route::post('/logout', [HomeContoller::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeContoller::class, 'dashboard'])->name('dashboard');
