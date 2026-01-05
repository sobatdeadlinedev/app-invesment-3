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
            'coin' => 'required|string|in:' . implode(',', array_keys(TradingSignal::getAvailableCoins())),
            'description' => 'nullable|string',
            'entry_price' => 'nullable|numeric|min:0',
            'target_price' => 'nullable|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $signal = TradingSignal::create([
                'title' => $request->title,
                'coin' => strtoupper($request->coin),
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

        $coins = TradingSignal::getAvailableCoins();
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
            'coin' => 'required|string|in:' . implode(',', array_keys(TradingSignal::getAvailableCoins())),
            'description' => 'nullable|string',
            'entry_price' => 'nullable|numeric|min:0',
            'target_price' => 'nullable|numeric|min:0',
            'stop_loss' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $signal->update([
                'title' => $request->title,
                'coin' => strtoupper($request->coin),
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
     * 
     * FIXED VERSION:
     * =============
     * Perhitungan yang benar untuk WIN dan LOSS:
     * 
     * WIN Example (Rate 63%):
     * - Saldo awal: 3000 USDT
     * - Bet: 30 USDT (locked)
     * - Step 1: Unlock → 3000 USDT (modal kembali)
     * - Step 2: Add profit (30 * 0.63) → 3018.9 USDT
     * - Step 3: Deduct fee (1%) → ~2988.7 USDT
     * 
     * LOSS Example:
     * - Saldo awal: 3000 USDT
     * - Bet: 30 USDT (locked)
     * - Step 1: Unlock → 3000 USDT (modal kembali dulu)
     * - Step 2: Deduct loss (30) → 2970 USDT (modal hilang)
     * - Step 3: Deduct fee (1%) → ~2940.3 USDT
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
                $betAmount = $participant->bet_amount;

                // STEP 1: Unlock balance (kembalikan modal ke trade balance)
                // Ini mengembalikan modal yang di-lock saat join signal
                $user->unlockBalance($betAmount);

                // STEP 2: Calculate profit/loss
                $profitLoss = 0;

                if ($signal->result === 'win') {
                    // WIN: User dapat profit MURNI (tidak termasuk modal)
                    // Modal sudah dikembalikan di step 1
                    // Profit = bet_amount * (rate_of_return / 100)
                    // Contoh: 30 * (63/100) = 18.9 USDT
                    $profitLoss = $betAmount * ($signal->rate_of_return / 100);

                    // Tambahkan profit ke trade balance
                    $user->addTradeBalance($profitLoss);
                } else {
                    // LOSS: User kehilangan seluruh modal bet
                    // Modal sudah dikembalikan di step 1, sekarang harus dikurangi lagi
                    $profitLoss = -$betAmount;

                    // Kurangi modal dari trade balance
                    $user->deductTradeBalance($betAmount);
                }

                // STEP 3: Calculate dan potong fee (1% dari trade balance saat ini)
                $fee = $user->calculateTradingFee();
                $user->deductTradeBalance($fee);

                // STEP 4: Add achieved volume (untuk tracking progress)
                $user->addAchievedVolume($betAmount);

                // STEP 5: Update participant record
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
                    'bet_amount' => $betAmount,
                    'signal_result' => $signal->result,
                    'rate_of_return' => $signal->rate_of_return,
                    'profit_loss' => $profitLoss,
                    'fee' => $fee,
                    'new_trade_balance' => $user->fresh()->trade_balance,
                    'achieved_volume' => $user->achieved_volume,
                ]);
            }

            // Mark signal as settled
            $signal->markAsSettled();

            DB::commit();

            // Format P/L dengan tanda + atau -
            $plText = $totalProfitLoss >= 0
                ? '+' . number_format($totalProfitLoss, 2)
                : number_format($totalProfitLoss, 2);

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal settled successfully! {$settledCount} participants processed. Total P/L: {$plText} USDT, Total Fees: " . number_format($totalFees, 2) . " USDT.");
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
