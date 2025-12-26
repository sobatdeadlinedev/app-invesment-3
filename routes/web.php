<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// Member Controllers
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\InvestController as MemberInvestController;
use App\Http\Controllers\Member\TeamController as MemberTeamController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;


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
    // Invest Routes
    Route::prefix('invest')->name('invest.')->group(function () {
        Route::get('/', [MemberInvestController::class, 'index'])->name('index');
    });
    // Team Routes
    Route::prefix('team')->name('team.')->group(function () {
        Route::get('/', [MemberTeamController::class, 'index'])->name('index');
    });
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [MemberProfileController::class, 'index'])->name('index');
    });
});
