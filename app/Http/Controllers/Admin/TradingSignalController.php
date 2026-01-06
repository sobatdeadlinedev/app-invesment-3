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
     * Close signal - opened_at akan diset di method closeSignal()
     */
    public function close(Request $request, $id)
    {
        Log::info('=== CLOSE SIGNAL START ===', [
            'signal_id' => $id,
            'request_data' => $request->all(),
            'user_id' => auth()->id(),
            'timestamp' => now(),
        ]);

        try {
            $signal = TradingSignal::findOrFail($id);

            Log::info('Signal found', [
                'signal_id' => $signal->id,
                'current_status' => $signal->status,
                'title' => $signal->title,
            ]);

            if ($signal->status !== 'open') {
                Log::warning('Signal status invalid', [
                    'signal_id' => $signal->id,
                    'status' => $signal->status,
                ]);

                return redirect()
                    ->route('admin.signals.index')
                    ->with('error', 'Signal is not open or already processed. Current status: ' . $signal->status);
            }

            Log::info('Validating request data');

            $validated = $request->validate([
                'result' => 'required|in:call,put,win,loss',
                'rate_of_return' => 'required|numeric|min:0|max:100',
            ], [
                'result.required' => 'Result must be selected',
                'result.in' => 'Result must be Call, Put, Win, or Loss',
                'rate_of_return.required' => 'Win rate must be filled',
                'rate_of_return.min' => 'Win rate minimum 0%',
                'rate_of_return.max' => 'Win rate maximum 100%',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            $resultForDb = $request->result;
            if ($request->result === 'call') {
                $resultForDb = 'win';
            } elseif ($request->result === 'put') {
                $resultForDb = 'loss';
            }

            Log::info('Result converted', [
                'original' => $request->result,
                'for_database' => $resultForDb,
            ]);

            DB::beginTransaction();
            Log::info('Database transaction started');

            Log::info('Calling closeSignal method', [
                'result' => $resultForDb,
                'rate_of_return' => $request->rate_of_return,
            ]);

            // Call closeSignal method - opened_at akan diset di dalam method ini
            $signal->closeSignal($resultForDb, $request->rate_of_return);

            Log::info('closeSignal method completed', [
                'signal_id' => $signal->id,
                'new_status' => $signal->fresh()->status,
                'result' => $signal->fresh()->result,
                'rate_of_return' => $signal->fresh()->rate_of_return,
                'opened_at' => $signal->fresh()->opened_at,
            ]);

            DB::commit();
            Log::info('Database transaction committed');

            Log::info('=== CLOSE SIGNAL SUCCESS ===', [
                'signal_id' => $signal->id,
                'result' => strtoupper($resultForDb),
                'display_as' => strtoupper($request->result),
                'rate_of_return' => $request->rate_of_return,
                'opened_at' => $signal->fresh()->opened_at,
            ]);

            $displayLabel = in_array($request->result, ['call', 'put'])
                ? strtoupper($request->result)
                : ($resultForDb === 'win' ? 'CALL' : 'PUT');

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal closed successfully as {$displayLabel} with {$request->rate_of_return}% win rate. Now you can settle all participants.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'signal_id' => $id,
            ]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('=== CLOSE SIGNAL FAILED ===', [
                'signal_id' => $id,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to close signal: ' . $e->getMessage() . ' (Check logs for details)');
        }
    }

    /**
     * Settle signal - closed_at akan diset di method markAsSettled()
     */
    public function settle($id)
    {
        Log::info('=== SETTLE SIGNAL START ===', ['signal_id' => $id]);

        $signal = TradingSignal::with('participants.user')->findOrFail($id);

        if ($signal->status !== 'closed') {
            Log::warning('Signal not closed yet', [
                'signal_id' => $signal->id,
                'status' => $signal->status,
            ]);

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('error', 'Signal must be closed before settling. Current status: ' . $signal->status);
        }

        try {
            DB::beginTransaction();

            $settledCount = 0;
            $totalRewards = 0;

            foreach ($signal->participants as $participant) {
                if ($participant->isSettled()) {
                    Log::info('Participant already settled, skipping', [
                        'participant_id' => $participant->id,
                        'user_id' => $participant->user_id,
                    ]);
                    continue;
                }

                $user = $participant->user;
                $betAmount = $participant->bet_amount;

                // ========== SIMPAN JOINED_AT ORIGINAL ==========
                $originalJoinedAt = $participant->joined_at; // 👈 TAMBAHKAN INI

                Log::info('BEFORE UPDATE Participant', [
                    'participant_id' => $participant->id,
                    'user_id' => $user->id,
                    'bet_amount' => $betAmount,
                    'joined_at_BEFORE' => $originalJoinedAt, // 👈 UPDATE INI
                    'status_BEFORE' => $participant->status,
                    'locked_balance_before' => $user->locked_balance,
                    'trade_balance_before' => $user->trade_balance,
                ]);

                // STEP 1: Unlock balance
                $user->unlockBalance($betAmount);

                // STEP 2: Calculate reward
                $reward = $betAmount * ($signal->rate_of_return / 100);

                // STEP 3: Add reward
                $user->addTradeBalance($reward);

                // STEP 4: Add volume
                $user->addAchievedVolume($betAmount);

                // STEP 5: Update participant - FORCE PRESERVE joined_at
                $participant->update([
                    'profit_loss' => $reward,
                    'fee_amount' => 0,
                    'status' => 'settled',
                    'settled_at' => now(),
                    'joined_at' => $originalJoinedAt, // 👈 TAMBAHKAN INI
                ]);

                $settledCount++;
                $totalRewards += $reward;

                $participantFresh = $participant->fresh();
                Log::info('AFTER UPDATE Participant', [
                    'participant_id' => $participantFresh->id,
                    'user_id' => $user->id,
                    'joined_at_AFTER' => $participantFresh->joined_at,
                    'status_AFTER' => $participantFresh->status,
                    'settled_at_AFTER' => $participantFresh->settled_at,
                    'reward' => $reward,
                    'trade_balance_after' => $user->fresh()->trade_balance,
                    'locked_balance_after' => $user->fresh()->locked_balance,
                    'dirty_attributes' => $participant->getDirty(),
                ]);
            }

            // Mark signal as settled
            $signal->markAsSettled();

            DB::commit();

            Log::info('=== SETTLE SIGNAL SUCCESS ===', [
                'signal_id' => $signal->id,
                'settled_count' => $settledCount,
                'total_rewards' => $totalRewards,
                'closed_at' => $signal->fresh()->closed_at,
            ]);

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal settled successfully! {$settledCount} participants received rewards. Total rewards distributed: " . number_format($totalRewards, 2) . " USDT.");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('=== SETTLE SIGNAL FAILED ===', [
                'signal_id' => $signal->id,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('error', 'Failed to settle signal: ' . $e->getMessage() . ' (Check logs for details)');
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
