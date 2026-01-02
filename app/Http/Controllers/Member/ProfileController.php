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

        // Optional: Get balance breakdown for detailed info
        $balanceBreakdown = Transaction::getUserBalanceBreakdown(auth()->id());

        return view('member.pages.profile.index', compact('user', 'wallets', 'userBalance', 'balanceBreakdown'));
    }
}
