<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});
