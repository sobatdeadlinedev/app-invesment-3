<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index()
    {
        $user = User::current();

        // Get team members (referred users)
        $teamMembers = $user->referredUsers()
            ->withCount('referrals as total_referrals')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalTeam = $teamMembers->count();

        // Generate referral link
        $referralLink = route('register', ['ref' => $user->refferal_code]);

        return view('member.pages.team.index', compact('user', 'teamMembers', 'totalTeam', 'referralLink'));
    }
}
