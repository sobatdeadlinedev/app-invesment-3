<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index()
    {
        // Get all users with their balance calculation
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })
            ->orderBy('name')
            ->paginate(15);

        // Calculate balance for each user
        $users->each(function ($user) {
            $user->balance = Transaction::getUserBalance($user->id);
        });

        return view('admin.pages.balance.index', compact('users'));
    }
}
