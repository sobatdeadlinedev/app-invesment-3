<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradingSignal;
use App\Models\SignalParticipant;
use App\Models\SignalAllowedUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TradingSignalController extends Controller
{
    public function index()
    {
        $signals = TradingSignal::with(['creator', 'allowedUsers'])
            ->withCount('participants')
            ->latest()
            ->paginate(15);

        return view('admin.pages.signals.index', compact('signals'));
    }

    public function create()
    {
        $coins = TradingSignal::getAvailableCoins();

        // FIXED: Get all users exclude admin using Spatie Permission
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone']);

        return view('admin.pages.signals.create', compact('coins', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'coin' => 'required|string|in:' . implode(',', array_keys(TradingSignal::getAvailableCoins())),
            'description' => 'nullable|string',
            'entry_price' => 'required|numeric|min:0',
            'target_price' => 'required|numeric|min:0',

            // Bet configuration
            'bet_type' => 'required|in:percentage,fixed',
            'bet_value' => 'required|numeric|min:0.01',

            // Access control
            'is_public' => 'nullable|boolean',
            'allowed_user_ids' => 'required_if:is_public,false|array',
            'allowed_user_ids.*' => 'exists:users,id',
        ], [
            'entry_price.required' => 'Opening price is required',
            'target_price.required' => 'Settlement price is required',
            'bet_type.required' => 'Bet type must be selected',
            'bet_value.required' => 'Bet value is required',
            'bet_value.min' => 'Bet value must be at least 0.01',
            'allowed_user_ids.required_if' => 'You must select at least one user for private signal',
        ]);

        try {
            DB::beginTransaction();

            $isPublic = $request->has('is_public') && $request->is_public;

            $signal = TradingSignal::create([
                'title' => $request->title,
                'coin' => strtoupper($request->coin),
                'description' => $request->description,
                'entry_price' => $request->entry_price,
                'target_price' => $request->target_price,
                'bet_type' => $request->bet_type,
                'bet_value' => $request->bet_value,
                'is_public' => $isPublic,
                'status' => 'open',
                'created_by' => auth()->id(),
            ]);

            // Jika private signal, simpan allowed users
            if (!$isPublic && !empty($request->allowed_user_ids)) {
                SignalAllowedUser::syncAllowedUsers($signal->id, $request->allowed_user_ids);
            }

            DB::commit();

            Log::info('Signal created', [
                'signal_id' => $signal->id,
                'title' => $signal->title,
                'bet_type' => $signal->bet_type,
                'bet_value' => $signal->bet_value,
                'is_public' => $signal->is_public,
                'allowed_users_count' => !$isPublic ? count($request->allowed_user_ids ?? []) : 'all',
            ]);

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
        $signal = TradingSignal::with(['creator', 'participants.user', 'allowedUsers.user'])
            ->findOrFail($id);

        $totalParticipants = $signal->participants->count();
        $totalBetAmount = $signal->participants->sum('bet_amount');

        return view('admin.pages.signals.show', compact('signal', 'totalParticipants', 'totalBetAmount'));
    }

    public function edit($id)
    {
        $signal = TradingSignal::with('allowedUsers')->findOrFail($id);

        if ($signal->status !== 'open') {
            return redirect()->route('admin.signals.index')->with('error', 'Cannot edit signal that is already closed or settled.');
        }

        $coins = TradingSignal::getAvailableCoins();

        // FIXED: Get all users exclude admin using Spatie Permission
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone']);

        return view('admin.pages.signals.edit', compact('signal', 'coins', 'users'));
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

            // Bet configuration
            'bet_type' => 'required|in:percentage,fixed',
            'bet_value' => 'required|numeric|min:0.01',

            // Access control
            'is_public' => 'nullable|boolean',
            'allowed_user_ids' => 'required_if:is_public,false|array',
            'allowed_user_ids.*' => 'exists:users,id',
        ], [
            'entry_price.required' => 'Opening price is required',
            'target_price.required' => 'Settlement price is required',
            'bet_type.required' => 'Bet type must be selected',
            'bet_value.required' => 'Bet value is required',
            'allowed_user_ids.required_if' => 'You must select at least one user for private signal',
        ]);

        try {
            DB::beginTransaction();

            $isPublic = $request->has('is_public') && $request->is_public;

            $signal->update([
                'title' => $request->title,
                'coin' => strtoupper($request->coin),
                'description' => $request->description,
                'entry_price' => $request->entry_price,
                'target_price' => $request->target_price,
                'bet_type' => $request->bet_type,
                'bet_value' => $request->bet_value,
                'is_public' => $isPublic,
            ]);

            // Sync allowed users
            if (!$isPublic && !empty($request->allowed_user_ids)) {
                SignalAllowedUser::syncAllowedUsers($signal->id, $request->allowed_user_ids);
            } else if ($isPublic) {
                // Jika diubah jadi public, hapus semua allowed users
                SignalAllowedUser::where('signal_id', $signal->id)->delete();
            }

            DB::commit();

            Log::info('Signal updated', [
                'signal_id' => $signal->id,
                'bet_type' => $signal->bet_type,
                'bet_value' => $signal->bet_value,
                'is_public' => $signal->is_public,
            ]);

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
        ]);

        try {
            $signal = TradingSignal::findOrFail($id);

            if ($signal->status !== 'open') {
                Log::warning('Signal status invalid', [
                    'signal_id' => $signal->id,
                    'status' => $signal->status,
                ]);

                return redirect()
                    ->route('admin.signals.index')
                    ->with('error', 'Signal is not open or already processed. Current status: ' . $signal->status);
            }

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

            $resultForDb = $request->result;
            if ($request->result === 'call') {
                $resultForDb = 'win';
            } elseif ($request->result === 'put') {
                $resultForDb = 'loss';
            }

            DB::beginTransaction();

            // Call closeSignal method - opened_at akan diset di dalam method ini
            $signal->closeSignal($resultForDb, $request->rate_of_return);

            DB::commit();

            Log::info('=== CLOSE SIGNAL SUCCESS ===', [
                'signal_id' => $signal->id,
                'result' => strtoupper($resultForDb),
                'rate_of_return' => $request->rate_of_return,
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
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to close signal: ' . $e->getMessage());
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
                    continue;
                }

                $user = $participant->user;
                $betAmount = $participant->bet_amount;

                // Unlock balance
                $user->unlockBalance($betAmount);

                // Calculate reward
                $reward = $betAmount * ($signal->rate_of_return / 100);

                // Add reward to trade balance
                $user->addTradeBalance($reward);

                // Add to achieved volume
                $user->addAchievedVolume($betAmount);

                // Update participant - boot method akan protect joined_at
                $participant->update([
                    'profit_loss' => $reward,
                    'fee_amount' => 0,
                    'status' => 'settled',
                    'settled_at' => now(),
                ]);

                $settledCount++;
                $totalRewards += $reward;

                Log::info('Participant settled', [
                    'participant_id' => $participant->id,
                    'user_id' => $user->id,
                    'bet_amount' => $betAmount,
                    'reward' => $reward,
                ]);
            }

            // Mark signal as settled
            $signal->markAsSettled();

            DB::commit();

            Log::info('=== SETTLE SIGNAL SUCCESS ===', [
                'signal_id' => $signal->id,
                'settled_count' => $settledCount,
                'total_rewards' => $totalRewards,
            ]);

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal settled successfully! {$settledCount} participants received rewards. Total rewards distributed: " . number_format($totalRewards, 2) . " USDT.");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('=== SETTLE SIGNAL FAILED ===', [
                'signal_id' => $signal->id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

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
