<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\TradingSignal;
use App\Models\SignalParticipant;
use Illuminate\Http\Request;

class InvestController extends Controller
{
    /**
     * Show coins list with signal count
     */
    public function index()
    {
        $user = auth()->user();
        $coins = TradingSignal::getAvailableCoins();

        // Count open signals per coin
        $signalCounts = [];
        foreach (array_keys($coins) as $coinSymbol) {
            $signalCounts[$coinSymbol] = TradingSignal::forCoin($coinSymbol)
                ->open()
                ->count();
        }

        return view('member.pages.invest.index', compact('coins', 'signalCounts'));
    }

    /**
     * Show signals for specific coin
     */
    public function detail(Request $request)
    {
        $user = auth()->user();

        // Get coin from query parameter OR signal_id
        if ($request->has('signal_id')) {
            // Direct signal access
            $signalId = $request->query('signal_id');
            $signal = TradingSignal::with('creator')
                ->withCount('participants')
                ->findOrFail($signalId);

            $participant = SignalParticipant::where('signal_id', $signal->id)
                ->where('user_id', $user->id)
                ->first();

            $hasJoined = !is_null($participant);

            return view('member.pages.invest.detail', compact('signal', 'participant', 'hasJoined'));
        }

        // Coin signals list
        $coin = strtoupper($request->query('coin', 'BTC'));
        $coinInfo = TradingSignal::getAvailableCoins()[$coin] ?? TradingSignal::getAvailableCoins()['BTC'];

        $openSignals = TradingSignal::forCoin($coin)
            ->open()
            ->with('creator')
            ->withCount('participants')
            ->latest()
            ->get();

        $joinedSignalIds = SignalParticipant::where('user_id', $user->id)
            ->pluck('signal_id')
            ->toArray();

        return view('member.pages.invest.coin-signals', compact('coin', 'coinInfo', 'openSignals', 'joinedSignalIds'));
    }
}
