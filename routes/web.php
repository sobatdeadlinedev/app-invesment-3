<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// Member Controllers
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\InvestController as MemberInvestController;
use App\Http\Controllers\Member\TeamController as MemberTeamController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\DepositController as MemberDepositController;
use App\Http\Controllers\Member\WithdrawController as MemberWithdrawController;

// Root Route - Auto redirect based on auth status
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->hasRole('admin')
            ? redirect()->route('admin.dashboard.index')
            : redirect()->route('member.dashboard.index');
    }
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
    });
});

// Member Routes
Route::prefix('member')->name('member.')->middleware(['auth', 'role:member'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [MemberDashboardController::class, 'index'])->name('index');
    });

    Route::prefix('invest')->name('invest.')->group(function () {
        Route::get('/', [MemberInvestController::class, 'index'])->name('index');
        Route::get('/detail', [MemberInvestController::class, 'detail'])->name('detail');
    });

    Route::prefix('team')->name('team.')->group(function () {
        Route::get('/', [MemberTeamController::class, 'index'])->name('index');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [MemberProfileController::class, 'index'])->name('index');
    });

    Route::prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/', [MemberDepositController::class, 'index'])->name('index');
    });

    Route::prefix('withdraw')->name('withdraw.')->group(function () {
        Route::get('/', [MemberWithdrawController::class, 'index'])->name('index');
    });
});
