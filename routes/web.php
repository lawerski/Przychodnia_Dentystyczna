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
Route::middleware(['auth', 'dentist'])->prefix('dentist')->name('dentist.')->group(function () {
    Route::get('/', [DentistPanelController::class, 'show'])->name('dashboard');
    Route::get('/profile', [DentistPanelController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [DentistPanelController::class, 'updateProfile'])->name('profile.update');
    Route::get('/history', [DentistPanelController::class, 'history'])->name('history');
    Route::get('/upcoming', [DentistPanelController::class, 'upcoming'])->name('upcoming');
});

// Rezerwacje
Route::controller(ReservationController::class)->group(function () {
    Route::put('/reservation/{reservation}/accept', 'accept')->name('reservation.accept');
});

// Autoryzacja
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
