<?php

use App\Http\Controllers\DentistPanelController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\PatientPanelController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminPanelController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'dentist'])->group(function () {
    Route::controller(DentistPanelController::class)->group(function () {
        Route::get('/dentist/history', 'history')->name('dentist.history');
        Route::get('/dentist/upcoming', 'upcoming')->name('dentist.upcoming');
        Route::get('/dentist/reviews', 'reviews')->name('dentist.reviews');
        Route::get('/dentist', 'show')->name('dentist.dashboard');
    });
    Route::controller(ReservationController::class)->group(function () {
        Route::put('/reservation/{reservation}/accept', 'accept')->name('reservation.accept');
    });
});

Route::middleware(['auth', 'patient'])->group(function () {
    Route::get('/patient', [PatientPanelController::class, 'index'])->name('patient.dashboard');
});

