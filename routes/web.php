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
use App\Http\Controllers\ServiceController;

// Panel admina
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/', [AdminPanelController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminPanelController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AdminPanelController::class, 'updateProfile'])->name('profile.update');
});

// Panel pacjenta
Route::middleware(['auth', 'patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/', [PatientPanelController::class, 'index'])->name('dashboard');
    Route::get('/profile', [PatientPanelController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [PatientPanelController::class, 'updateProfile'])->name('profile.update');
});

// Panel dentysty
Route::middleware(['auth', 'dentist'])->group(function () {
    Route::controller(DentistPanelController::class)->group(function () {
        Route::get('/dentist/history', 'history')->name('dentist.history');
        Route::get('/dentist/upcoming', 'upcoming')->name('dentist.upcoming');
        Route::get('/dentist/reviews', 'reviews')->name('dentist.reviews');
        Route::get('/dentist/services', 'services')->name('dentist.services');
        Route::get('/dentist', 'show')->name('dentist.dashboard');
        Route::get('/dentist/profile', 'editProfile')->name('dentist.profile.edit');
        Route::post('/dentist/profile', 'updateProfile')->name('dentist.profile.update');
    });
    Route::controller(ReservationController::class)->group(function () {
        Route::put('/reservation/{reservation}/accept', 'accept')->name('reservation.accept');
    });
});

// Autoryzacja
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Services
Route::get('/service/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::put('/service/{service}/update', [ServiceController::class, 'update'])->name('service.update');
Route::delete('/service/{service}/delete', [ServiceController::class, 'destroy'])->name('service.delete');
