<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::current();
        $wallets = $user->wallets()->get();

        // Get real user balance using model helper
        $userBalance = Transaction::getUserBalance(auth()->id());

        // Get balance breakdown for detailed info
        $balanceBreakdown = Transaction::getUserBalanceBreakdown(auth()->id());

        // Get today's PnL (using accessor)
        $todayPnl = $user->today_pnl;

        // Get today's trading stats (optional, for additional info)
        $todayStats = $user->getTodayTradingStats();

        // Get recent transactions for each type (limit to 5 for preview)
        $deposits = Transaction::forUser(auth()->id())
            ->deposit()
            ->latest()
            ->limit(5)
            ->get();

        $withdrawals = Transaction::forUser(auth()->id())
            ->withdrawal()
            ->latest()
            ->limit(5)
            ->get();

        $commissions = Transaction::forUser(auth()->id())
            ->commission()
            ->latest()
            ->limit(5)
            ->get();

        return view('member.pages.profile.index', compact(
            'user',
            'wallets',
            'userBalance',
            'balanceBreakdown',
            'todayPnl',
            'todayStats',
            'deposits',
            'withdrawals',
            'commissions'
        ));
    }
}
