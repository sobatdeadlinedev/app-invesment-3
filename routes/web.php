<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WalletController as AdminWalletController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\ReferralController as AdminReferralController;
use App\Http\Controllers\Admin\CommissionController as AdminCommissionController;
use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
// Member Controllers
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\InvestController as MemberInvestController;
use App\Http\Controllers\Member\TeamController as MemberTeamController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\DepositController as MemberDepositController;
use App\Http\Controllers\Member\WithdrawController as MemberWithdrawController;
use App\Http\Controllers\Member\WalletController as MemberWalletController;

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

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
    });

    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/', [AdminWalletController::class, 'index'])->name('index');
    });

    Route::prefix('team')->name('team.')->group(function () {
        Route::get('/', [AdminTeamController::class, 'index'])->name('index');
    });

    Route::prefix('refferal')->name('refferal.')->group(function () {
        Route::get('/', [AdminReferralController::class, 'index'])->name('index');
    });

    Route::prefix('commission')->name('commission.')->group(function () {
        Route::get('/', [AdminCommissionController::class, 'index'])->name('index');
    });

    Route::prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/', [AdminDepositController::class, 'index'])->name('index');
        Route::get('/{deposit}', [AdminDepositController::class, 'show'])->name('show');
        Route::post('/{deposit}/approve', [AdminDepositController::class, 'approve'])->name('approve');
        Route::post('/{deposit}/reject', [AdminDepositController::class, 'reject'])->name('reject');
    });

    Route::prefix('withdrawal')->name('withdrawal.')->group(function () {
        Route::get('/', [AdminWithdrawalController::class, 'index'])->name('index');
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
        Route::post('/store', [MemberDepositController::class, 'store'])->name('store');
        Route::get('/history', [MemberDepositController::class, 'history'])->name('history');
    });

    Route::prefix('withdraw')->name('withdraw.')->group(function () {
        Route::get('/', [MemberWithdrawController::class, 'index'])->name('index');
        Route::post('/store', [MemberWithdrawController::class, 'store'])->name('store');
        Route::get('/history', [MemberWithdrawController::class, 'history'])->name('history');
        Route::delete('/cancel/{reference}', [MemberWithdrawController::class, 'cancel'])->name('cancel');
    });

    // Wallet Routes
    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::post('/', [MemberWalletController::class, 'store'])->name('store');
        Route::put('/{wallet}', [MemberWalletController::class, 'update'])->name('update');
        Route::delete('/{wallet}', [MemberWalletController::class, 'destroy'])->name('destroy');
    });
});
