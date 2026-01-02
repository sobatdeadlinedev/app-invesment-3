<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::current();
        $announcement = Config::get('app_announcement')['value'] ?? null;
        return view('member.pages.dashboard.index', compact('user', 'announcement'));
    }
}
