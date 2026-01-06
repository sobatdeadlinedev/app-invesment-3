<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function store(Request $request)
    {
        $user = User::current();

        // Validasi max 3 wallet
        if ($user->wallets()->count() >= 3) {
            return back()->with('error', 'Maksimal 3 wallet per user');
        }

        $request->validate([
            'type' => 'required|in:trc20,bep20',
            'account_number' => 'required|string|max:255',
        ]);

        $user->wallets()->create([
            'type' => $request->type,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', 'Wallet berhasil ditambahkan');
    }

    public function update(Request $request, Wallet $wallet)
    {
        $user = User::current();

        // Pastikan wallet milik user yang login
        if ($wallet->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'type' => 'required|in:trc20,bep20',
            'account_number' => 'required|string|max:255',
        ]);

        $wallet->update([
            'type' => $request->type,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', 'Wallet berhasil diupdate');
    }

    public function destroy(Wallet $wallet)
    {
        $user = User::current();

        // Pastikan wallet milik user yang login
        if ($wallet->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized');
        }

        $wallet->delete();

        return back()->with('success', 'Wallet berhasil dihapus');
    }
}
