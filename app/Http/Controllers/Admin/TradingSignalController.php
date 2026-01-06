<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradingSignal;
use App\Models\SignalParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TradingSignalController extends Controller
{
    public function index()
    {
        $signals = TradingSignal::with('creator')
            ->withCount('participants')
            ->latest()
            ->paginate(15);

        return view('admin.pages.signals.index', compact('signals'));
    }

    public function create()
    {
        $coins = TradingSignal::getAvailableCoins();
        return view('admin.pages.signals.create', compact('coins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'coin' => 'required|string|in:' . implode(',', array_keys(TradingSignal::getAvailableCoins())),
            'description' => 'nullable|string',
            'entry_price' => 'required|numeric|min:0',
            'target_price' => 'required|numeric|min:0',
        ], [
            'entry_price.required' => 'Opening price is required',
            'target_price.required' => 'Settlement price is required',
        ]);

        try {
            DB::beginTransaction();

            $signal = TradingSignal::create([
                'title' => $request->title,
                'coin' => strtoupper($request->coin),
                'description' => $request->description,
                'entry_price' => $request->entry_price,
                'target_price' => $request->target_price,
                'status' => 'open',
                'opened_at' => now(),
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.signals.index')
                ->with('success', 'Trading signal created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create signal failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create signal: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $signal = TradingSignal::with(['creator', 'participants.user'])
            ->findOrFail($id);

        $totalParticipants = $signal->participants->count();
        $totalBetAmount = $signal->participants->sum('bet_amount');

        return view('admin.pages.signals.show', compact('signal', 'totalParticipants', 'totalBetAmount'));
    }

    public function edit($id)
    {
        $signal = TradingSignal::findOrFail($id);

        if ($signal->status !== 'open') {
            return redirect()->route('admin.signals.index')->with('error', 'Cannot edit signal that is already closed or settled.');
        }

        $coins = TradingSignal::getAvailableCoins();
        return view('admin.pages.signals.edit', compact('signal', 'coins'));
    }

    public function update(Request $request, $id)
    {
        $signal = TradingSignal::findOrFail($id);

        if ($signal->status !== 'open') {
            return redirect()->route('admin.signals.index')->with('error', 'Cannot update signal.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'coin' => 'required|string|in:' . implode(',', array_keys(TradingSignal::getAvailableCoins())),
            'description' => 'nullable|string',
            'entry_price' => 'required|numeric|min:0',
            'target_price' => 'required|numeric|min:0',
        ], [
            'entry_price.required' => 'Opening price is required',
            'target_price.required' => 'Settlement price is required',
        ]);

        try {
            DB::beginTransaction();

            $signal->update([
                'title' => $request->title,
                'coin' => strtoupper($request->coin),
                'description' => $request->description,
                'entry_price' => $request->entry_price,
                'target_price' => $request->target_price,
            ]);

            DB::commit();

            return redirect()->route('admin.signals.show', $signal->id)->with('success', 'Signal updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update signal failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update signal.');
        }
    }

    /**
     * Close signal - NEW: call/put instead of win/loss
     */
    public function close(Request $request, $id)
    {
        $signal = TradingSignal::findOrFail($id);

        if ($signal->status !== 'open') {
            return redirect()
                ->route('admin.signals.index')
                ->with('error', 'Signal is not open or already processed.');
        }

        $request->validate([
            'result' => 'required|in:call,put',
            'rate_of_return' => 'required|numeric|min:0|max:100',
        ], [
            'result.required' => 'Result (Call/Put) must be selected',
            'result.in' => 'Result must be either Call or Put',
            'rate_of_return.required' => 'Win rate must be filled',
            'rate_of_return.min' => 'Win rate minimum 0%',
            'rate_of_return.max' => 'Win rate maximum 100%',
        ]);

        try {
            DB::beginTransaction();

            $signal->closeSignal($request->result, $request->rate_of_return);

            DB::commit();

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', 'Signal closed successfully as ' . strtoupper($request->result) . ' with ' . $request->rate_of_return . '% win rate. Now you can settle all participants.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Close signal failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to close signal: ' . $e->getMessage());
        }
    }

    /**
     * Settle signal - SIMPLIFIED: NO LOSS, NO FEE, ALWAYS REWARD!
     */
    public function settle($id)
    {
        $signal = TradingSignal::with('participants.user')->findOrFail($id);

        if ($signal->status !== 'closed') {
            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('error', 'Signal must be closed before settling. Please close the signal first.');
        }

        try {
            DB::beginTransaction();

            $settledCount = 0;
            $totalRewards = 0;

            foreach ($signal->participants as $participant) {
                if ($participant->isSettled()) {
                    continue;
                }

                $user = $participant->user;
                $betAmount = $participant->bet_amount;

                // STEP 1: Unlock balance
                $user->unlockBalance($betAmount);

                // STEP 2: Calculate reward (ALWAYS POSITIVE!)
                $reward = $betAmount * ($signal->rate_of_return / 100);

                // STEP 3: Add reward
                $user->addTradeBalance($reward);

                // STEP 4: Add volume
                $user->addAchievedVolume($betAmount);

                // STEP 5: Update participant
                $participant->update([
                    'profit_loss' => $reward,
                    'fee_amount' => 0,
                    'status' => 'settled',
                    'settled_at' => now(),
                ]);

                $settledCount++;
                $totalRewards += $reward;

                Log::info('Participant settled', [
                    'signal_id' => $signal->id,
                    'user_id' => $user->id,
                    'bet_amount' => $betAmount,
                    'signal_result' => $signal->result,
                    'win_rate' => $signal->rate_of_return,
                    'reward' => $reward,
                    'new_trade_balance' => $user->fresh()->trade_balance,
                ]);
            }

            $signal->markAsSettled();

            DB::commit();

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal settled successfully! {$settledCount} participants received rewards. Total rewards distributed: " . number_format($totalRewards, 2) . " USDT.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Settle signal failed: ' . $e->getMessage());
            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('error', 'Failed to settle signal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $signal = TradingSignal::withCount('participants')->findOrFail($id);

        if ($signal->participants_count > 0) {
            return redirect()
                ->route('admin.signals.index')
                ->with('error', 'Cannot delete signal with participants.');
        }

        $signal->delete();

        return redirect()
            ->route('admin.signals.index')
            ->with('success', 'Signal deleted successfully.');
    }
}
