<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReferralUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    public function index()
    {
        $referralUsages = ReferralUsage::with(['referrer', 'referred'])
            ->latest('used_at')
            ->get();

        return view('admin.pages.refferal.index', compact('referralUsages'));
    }
}
