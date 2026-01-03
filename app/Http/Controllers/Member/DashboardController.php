<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::current();
        $announcement = Config::get('app_announcement')['value'] ?? null;
        $userBalance = Transaction::getUserBalance(auth()->id());

        // Generate referral link
        $referralLink = route('register', ['ref' => $user->refferal_code]);

        return view('member.pages.dashboard.index', compact('user', 'announcement', 'userBalance', 'referralLink'));
    }
}
