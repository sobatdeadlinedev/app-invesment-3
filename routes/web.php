<?php

use Illuminate\Support\Facades\Route;
// Admin Controllers
use App\Http\Controllers\Auth\LoginController;
// Member Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;


// Route::get('/', function () {
//     if (auth()->check()) {
//         return auth()->user()->hasRole('admin')
//             ? redirect()->route('admin.dashboard.index')
//             : redirect()->route('member.dashboard.index');
//     }
//     return redirect()->route('login');
// });

// Route::get('/', function () { return view('welcome'); });

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard Routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
    });
});
// Member Routes
Route::prefix('member')->name('member.')->group(function () {
    // Dashboard Routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [MemberDashboardController::class, 'index'])->name('index');
    });
});
