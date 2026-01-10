<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index()
    {
        $users = User::role('member')
            ->withCount('referrals')
            ->latest()
            ->get();

        // Load multi-level referrals for all users
        foreach ($users as $user) {
            // Force load the attribute
            $user->loadMissing('referrals');
        }

        return view('admin.pages.team.index', compact('users'));
    }
}
