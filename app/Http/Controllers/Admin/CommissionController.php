<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Transaction::with(['user', 'sourceUser'])
            ->commission()
            ->latest()
            ->paginate(10);

        return view('admin.pages.commission.index', compact('commissions'));
    }
}
