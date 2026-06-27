<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KidController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\VaccineController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false, // Only admin can create users for now
    'reset' => false,
    'verify' => false,
]);

// Redirect /home to /dashboard since laravel/ui defaults to /home
Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/global-search', [DashboardController::class, 'globalSearch'])->name('global.search');
    Route::resource('kids', KidController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('consultations', ConsultationController::class);
    Route::resource('vaccines', VaccineController::class);
    
    Route::middleware([\App\Http\Middleware\CheckRole::class])->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
