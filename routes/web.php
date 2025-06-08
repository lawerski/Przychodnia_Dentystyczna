<?php

use App\Http\Controllers\DentistPanelController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PublicDentistController; // Add this line
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\PatientPanelController;

use App\Http\Controllers\Admin\DentistController;

use App\Http\Controllers\ServiceController;

// Main page
Route::get('/', function () {
    return view('main');
})->name('main');

// Publiczne trasy
Route::get('/dentists', [PublicDentistController::class, 'index'])->name('dentists.index');
Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
Route::get('/dentists/{dentist}', [\App\Http\Controllers\DentistController::class, 'show'])->name('dentists.show');
Route::get('/services/service/{service}', [ServiceController::class, 'show'])->name('service.show');

// Panel admina
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('dentists', \App\Http\Controllers\Admin\DentistController::class);
    Route::resource('reservations', \App\Http\Controllers\ReservationController::class);
    Route::get('/', [AdminPanelController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminPanelController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AdminPanelController::class, 'updateProfile'])->name('profile.update');
    Route::get('/totp', [AdminPanelController::class, 'generateTotpSecret'])->name('totp');
    Route::resource('dentists', \App\Http\Controllers\Admin\DentistController::class);
    Route::get('services', [ServiceController::class, 'index'])->name('service.index');
});

// Panel pacjenta
Route::middleware(['auth', 'patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/', [PatientPanelController::class, 'index'])->name('dashboard');
    Route::post('/reservation/{reservation}/cancel', [PatientPanelController::class, 'cancelReservation'])->name('reservation.cancel');
    Route::get('/profile', [PatientPanelController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [PatientPanelController::class, 'updateProfile'])->name('profile.update');
    Route::get('/history', [PatientPanelController::class, 'history'])->name('history'); // Dodaj to
    Route::get('/totp', [PatientPanelController::class, 'generateTotpSecret'])->name('totp');
});

// Panel dentysty
Route::middleware(['auth', 'dentist'])->group(function () {
    Route::controller(DentistPanelController::class)->group(function () {
        Route::get('/dentist/history', 'history')->name('dentist.history');
        Route::get('/dentist/upcoming', 'upcoming')->name('dentist.upcoming');
        Route::get('/dentist/reviews', 'reviews')->name('dentist.reviews');
        Route::get('/dentist/services', 'services')->name('dentist.services');
        Route::get('/dentist/calendar', 'calendar')->name('dentist.calendar');
        Route::get('/dentist', 'show')->name('dentist.dashboard');
        Route::get('/dentist/profile', 'editProfile')->name('dentist.profile.edit');
        Route::post('/dentist/profile', 'updateProfile')->name('dentist.profile.update');

        Route::get('/dentist/totp', [DentistPanelController::class, 'generateTotpSecret'])->name('dentist.totp');
        Route::get('/dentist/totp', 'generateTotpSecret')->name('dentist.totp');

        Route::controller(ReservationController::class)->group(function () {
            Route::put('/reservation/{reservation}/accept', 'accept')->name('reservation.accept');
        });
    });
});

// Autoryzacja
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Services
Route::middleware(['auth', 'role:admin,dentist'])->group( function () {
    Route::get('/service/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/service/{service}/update', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service/{service}/delete', [ServiceController::class, 'destroy'])->name('service.delete');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
});

// Totp
Route::post('/totp-verify', [LoginController::class, 'verifyTotp'])->name('totp.verify');
Route::get('/password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/reservation', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/available-slots', [App\Http\Controllers\ReservationController::class, 'availableSlots'])->name('reservation.availableSlots');
