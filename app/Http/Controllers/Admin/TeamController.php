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
            ->get()
            ->map(function ($user) {
                // Append multi-level referrals data
                $user->append('multi_level_referrals', 'total_multi_level_referrals');
                return $user;
            });

        return view('admin.pages.team.index', compact('users'));
    }
}
