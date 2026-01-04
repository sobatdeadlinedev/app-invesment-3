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
            ->with(['referrals.referred'])
            ->latest()
            ->get();

        return view('admin.pages.team.index', compact('users'));
    }
}
