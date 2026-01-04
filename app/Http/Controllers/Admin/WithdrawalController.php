<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Transaction::with(['user', 'wallet'])
            ->withdrawal()
            ->latest()
            ->paginate(10);

        return view('admin.pages.withdrawal.index', compact('withdrawals'));
    }
}
