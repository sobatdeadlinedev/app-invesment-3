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
    /**
     * Display list of signals
     */
    public function index()
    {
        $signals = TradingSignal::with('creator')
            ->withCount('participants')
            ->latest()
            ->paginate(15);

        return view('admin.pages.signals.index', compact('signals'));
    }

    /**
     * Show create signal form
     */
    public function create()
    {
        $coins = TradingSignal::getAvailableCoins();
        return view('admin.pages.signals.create', compact('coins'));
    }

    /**
     * Store new signal
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'coin' => 'required|string|in:' . implode(',', array_keys(TradingSignal::getAvailableCoins())), // NEW
            'description' => 'nullable|string',
            'entry_price' => 'nullable|numeric|min:0',
            'target_price' => 'nullable|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $signal = TradingSignal::create([
                'title' => $request->title,
                'coin' => strtoupper($request->coin), // NEW
                'description' => $request->description,
                'entry_price' => $request->entry_price,
                'target_price' => $request->target_price,
                'stop_loss' => $request->stop_loss,
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

    /**
     * Show signal details with participants
     */
    public function show($id)
    {
        $signal = TradingSignal::with(['creator', 'participants.user'])
            ->findOrFail($id);

        $totalParticipants = $signal->participants->count();
        $totalBetAmount = $signal->participants->sum('bet_amount');

        return view('admin.pages.signals.show', compact('signal', 'totalParticipants', 'totalBetAmount'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $signal = TradingSignal::findOrFail($id);

        if ($signal->status !== 'open') {
            return redirect()->route('admin.signals.index')->with('error', 'Cannot edit signal that is already closed or settled.');
        }

        $coins = TradingSignal::getAvailableCoins(); // NEW
        return view('admin.pages.signals.edit', compact('signal', 'coins'));
    }

    /**
     * Update signal
     */
    public function update(Request $request, $id)
    {
        $signal = TradingSignal::findOrFail($id);

        if ($signal->status !== 'open') {
            return redirect()->route('admin.signals.index')->with('error', 'Cannot update signal.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'coin' => 'required|string|in:' . implode(',', array_keys(TradingSignal::getAvailableCoins())), // NEW
            'description' => 'nullable|string',
            'entry_price' => 'nullable|numeric|min:0',
            'target_price' => 'nullable|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $signal->update([
                'title' => $request->title,
                'coin' => strtoupper($request->coin), // NEW
                'description' => $request->description,
                'entry_price' => $request->entry_price,
                'target_price' => $request->target_price,
                'stop_loss' => $request->stop_loss,
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
     * Close signal and set result
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
            'result' => 'required|in:win,loss',
            'rate_of_return' => 'required|numeric|min:0|max:100',
        ], [
            'result.required' => 'Result (Win/Loss) harus dipilih',
            'rate_of_return.required' => 'Rate of return harus diisi',
            'rate_of_return.min' => 'Rate of return minimal 0%',
            'rate_of_return.max' => 'Rate of return maksimal 100%',
        ]);

        try {
            DB::beginTransaction();

            // Close signal
            $signal->closeSignal($request->result, $request->rate_of_return);

            DB::commit();

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', 'Signal closed successfully. Now you can settle all participants.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Close signal failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Failed to close signal: ' . $e->getMessage());
        }
    }

    /**
     * Settle signal - process all participants
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
            $totalProfitLoss = 0;
            $totalFees = 0;

            foreach ($signal->participants as $participant) {
                if ($participant->isSettled()) {
                    continue; // Skip jika sudah settled
                }

                $user = $participant->user;

                // Unlock balance
                $user->unlockBalance($participant->bet_amount);

                // Calculate profit/loss
                $profitLoss = 0;
                if ($signal->result === 'win') {
                    $profitLoss = $participant->bet_amount * ($signal->rate_of_return / 100);
                } else {
                    $profitLoss = -$participant->bet_amount;
                }

                // Calculate fee (1% dari trade balance saat ini)
                $fee = $user->calculateTradingFee();

                // Update trade balance
                // Rumus: trade_balance = trade_balance + profit/loss - fee
                if ($profitLoss > 0) {
                    $user->addTradeBalance($profitLoss);
                } else {
                    $user->deductTradeBalance(abs($profitLoss));
                }
                $user->deductTradeBalance($fee);

                // Add achieved volume
                $user->addAchievedVolume($participant->bet_amount);

                // Update participant
                $participant->update([
                    'profit_loss' => $profitLoss,
                    'fee_amount' => $fee,
                    'status' => 'settled',
                    'settled_at' => now(),
                ]);

                $settledCount++;
                $totalProfitLoss += $profitLoss;
                $totalFees += $fee;

                Log::info('Participant settled', [
                    'signal_id' => $signal->id,
                    'user_id' => $user->id,
                    'bet_amount' => $participant->bet_amount,
                    'profit_loss' => $profitLoss,
                    'fee' => $fee,
                    'achieved_volume' => $user->achieved_volume,
                ]);
            }

            // Mark signal as settled
            $signal->markAsSettled();

            DB::commit();

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal settled successfully! {$settledCount} participants processed. Total P/L: " . number_format($totalProfitLoss, 2) . " USDT, Total Fees: " . number_format($totalFees, 2) . " USDT.");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Settle signal failed: ' . $e->getMessage(), [
                'signal_id' => $signal->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('error', 'Failed to settle signal: ' . $e->getMessage());
        }
    }

    /**
     * Delete signal (only if no participants)
     */
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
