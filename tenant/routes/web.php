<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MeetingRoomController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    // -------------------
    // 👤 USER ROUTES
    // -------------------
    Route::middleware(['is_user'])->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');

        // User bisa melihat semua ruangan meeting
        Route::get('/meeting-rooms', [MeetingRoomController::class, 'index'])
            ->name('meeting-rooms.index');

        // User bisa mencari ruangan meeting (search)
        Route::get('/meeting-rooms/search', [MeetingRoomController::class, 'search'])
            ->name('meeting-rooms.search');

        // User bisa mengelola profilnya sendiri
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // User bisa menyewa ruangan
        Route::resource('/rentals', RentalController::class)->only(['index', 'store']);
    });


    Route::middleware(['is_admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // CRUD kategori dan ruangan
        Route::resource('/categories', CategoryController::class);
        Route::resource('/meeting-rooms', MeetingRoomController::class);

        // Admin bisa melihat dan konfirmasi pengembalian sewa
        Route::resource('/rentals', RentalController::class)->except(['store']);

        // Cetak laporan penyewaan
        Route::get('/rentals/print', [RentalController::class, 'print'])->name('rentals.print');
    });
});