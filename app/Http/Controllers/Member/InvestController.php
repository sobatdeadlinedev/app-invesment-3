<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\TradingSignal;
use App\Models\SignalParticipant;
use Illuminate\Http\Request;

class InvestController extends Controller
{
    /**
     * Show trading signals list
     */
    public function index()
    {
        $user = auth()->user();

        // Get open signals
        $openSignals = TradingSignal::open()
            ->with('creator')
            ->withCount('participants')
            ->latest()
            ->get();

        // Get signal IDs that user has joined
        $joinedSignalIds = SignalParticipant::where('user_id', $user->id)
            ->pluck('signal_id')
            ->toArray();

        return view('member.pages.invest.index', compact('openSignals', 'joinedSignalIds'));
    }

    /**
     * Show trading signal detail
     */
    public function detail(Request $request)
    {
        $user = auth()->user();

        // Get signal_id from query parameter
        $signalId = $request->query('signal_id');

        if (!$signalId) {
            return redirect()
                ->route('member.invest.index')
                ->with('error', 'Signal not found');
        }

        // Get signal with relations
        $signal = TradingSignal::with('creator')
            ->withCount('participants')
            ->findOrFail($signalId);

        // Check if user has joined this signal
        $participant = SignalParticipant::where('signal_id', $signal->id)
            ->where('user_id', $user->id)
            ->first();

        $hasJoined = !is_null($participant);

        return view('member.pages.invest.detail', compact('signal', 'participant', 'hasJoined'));
    }
}
