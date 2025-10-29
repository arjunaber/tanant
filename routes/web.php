<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes (require login)
Route::middleware('auth')->group(function () {
    // Dashboard route - TAMBAHKAN INI
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Unit routes
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/{id}', [UnitController::class, 'show'])->name('units.show');
    Route::get('/units/search/ajax', [UnitController::class, 'search'])->name('units.search.ajax');

    // Rental routes
    Route::get('/rentals/create/{unit}', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals/store/{unit}', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/payment/{rental}', [RentalController::class, 'payment'])->name('rentals.payment');
    Route::get('/my-rentals', [RentalController::class, 'myRentals'])->name('rentals.my-rentals');
    Route::get('/rentals/{id}', [RentalController::class, 'show'])->name('rentals.show');
    Route::post('/rentals/calculate-price/{unit}', [RentalController::class, 'calculatePrice'])->name('rentals.calculate-price');

    // Payment routes
    Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback')->withoutMiddleware(['auth', 'web']);
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
    Route::get('/payment/check-status/{rental}', [PaymentController::class, 'checkStatus'])->name('payment.check-status');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [HomeController::class, 'adminIndex'])->name('admin.index');
    // Unit routes
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{id}', [UnitController::class, 'show'])->name('units.show');
    Route::get('/units/search/ajax', [UnitController::class, 'search'])->name('units.search.ajax');
    Route::get('/units/{id}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.destroy');
    Route::get('/admin/units/data', [UnitController::class, 'getUnitsData'])->name('admin.units.data');

    // Categories Routes
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // Users Routes  
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
