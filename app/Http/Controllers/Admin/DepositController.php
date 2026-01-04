<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Transaction::with(['user'])
            ->deposit()
            ->latest()
            ->paginate(10);

        return view('admin.pages.deposit.index', compact('deposits'));
    }
}
