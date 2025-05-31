<?php

use App\Http\Controllers\DentistPanelController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(DentistPanelController::class)->group(function () {
    Route::get('/dentist/history', 'history')->name('dentist.history');
    Route::get('/dentist/upcoming', 'upcoming')->name('dentist.upcoming');
    Route::get('/dentist', 'show')->name('dentist.show');
});
Route::controller(ReservationController::class)->group(function () {
    Route::put('/reservation/{reservation}/accept', 'accept')->name('reservation.accept');
});
