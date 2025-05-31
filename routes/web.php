<?php

use App\Http\Controllers\DentistPanelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(DentistPanelController::class)->group(function () {
    Route::get('/dentist/history', 'history')->name('dentist.history');
    Route::get('/dentist/upcoming', 'upcoming')->name('dentist.upcoming');
    Route::get('/dentist', 'show')->name('dentist.show');
});
