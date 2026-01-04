<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function index()
    {
        $users = User::role('member')
            ->with('wallets')
            ->latest()
            ->get()
            ->map(function ($user) {
                // Ambil maksimal 3 wallet dan pad dengan null jika kurang
                $wallets = $user->wallets->take(3)->values();

                // Pad dengan null sampai 3
                while ($wallets->count() < 3) {
                    $wallets->push(null);
                }

                $user->wallet_1 = $wallets[0];
                $user->wallet_2 = $wallets[1];
                $user->wallet_3 = $wallets[2];

                return $user;
            });

        return view('admin.pages.wallet.index', compact('users'));
    }
}
