<?php

use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

Route::get('/point-checkin/{id}', [PointController::class, 'checkinPage'])->name('point.checkin');
Route::post('/lapor-checkin', [PointController::class, 'checkin'])->name('point.laporCheckin');
