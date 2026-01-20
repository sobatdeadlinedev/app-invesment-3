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
        try {
            $signal = TradingSignal::findOrFail($id);

            if ($signal->status !== 'open') {
                return redirect()
                    ->route('admin.signals.index')
                    ->with('error', 'Signal is not open.');
            }

            $validated = $request->validate([
                'rate_of_return' => 'required|numeric|min:0|max:100',
            ]);

            DB::beginTransaction();

            // Auto-detect result berdasarkan price
            if ($signal->entry_price < $signal->target_price) {
                $result = 'win'; // CALL WIN, PUT LOSS
            } else {
                $result = 'loss'; // PUT WIN, CALL LOSS
            }

            $signal->closeSignal($result, $request->rate_of_return);

            DB::commit();

            $displayResult = $result === 'win' ? 'CALL WIN' : 'PUT WIN';

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal closed as {$displayResult} with {$request->rate_of_return}% win rate.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to close signal: ' . $e->getMessage());
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
            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('error', 'Signal must be closed before settling.');
        }

        try {
            DB::beginTransaction();

            $settledCount = 0;
            $winnersCount = 0;
            $losersCount = 0;
            $totalRewards = 0;
            $totalLosses = 0;

            foreach ($signal->participants as $participant) {
                if ($participant->isSettled()) {
                    continue;
                }

                $user = $participant->user;
                $betAmount = $participant->bet_amount;

                // Cek apakah participant menang atau kalah
                // signal->result: 'win' = CALL WIN, 'loss' = PUT WIN
                $isWinner = ($participant->prediction === $signal->result);

                if ($isWinner) {
                    // MENANG
                    // 1. Unlock bet amount (kembalikan saldo bet)
                    $user->unlockBalance($betAmount);

                    // 2. Hitung profit
                    $profit = $betAmount * ($signal->rate_of_return / 100);

                    // 3. Tambahkan profit ke trade balance
                    $user->addTradeBalance($profit);

                    $profitLoss = $profit; // Profit saja (bet amount sudah dikembalikan)

                    $winnersCount++;
                    $totalRewards += $profit;

                    Log::info('Participant WON', [
                        'participant_id' => $participant->id,
                        'user_id' => $user->id,
                        'bet_amount' => $betAmount,
                        'profit' => $profit,
                        'prediction' => $participant->prediction,
                    ]);
                } else {
                    // KALAH
                    // Bet amount tetap locked (hilang)
                    // Tidak unlock balance, tidak dapat apa-apa

                    $profitLoss = -$betAmount; // Loss

                    $losersCount++;
                    $totalLosses += $betAmount;

                    Log::info('Participant LOST', [
                        'participant_id' => $participant->id,
                        'user_id' => $user->id,
                        'bet_amount' => $betAmount,
                        'loss' => $betAmount,
                        'prediction' => $participant->prediction,
                    ]);
                }

                // Add to achieved volume (baik menang atau kalah)
                $user->addAchievedVolume($betAmount);

                // Update participant status
                $participant->update([
                    'profit_loss' => $profitLoss,
                    'fee_amount' => 0,
                    'status' => 'settled',
                    'settled_at' => now(),
                ]);

                $settledCount++;
            }

            // Mark signal as settled
            $signal->markAsSettled();

            DB::commit();

            Log::info('=== SETTLE SIGNAL SUCCESS ===', [
                'signal_id' => $signal->id,
                'total_settled' => $settledCount,
                'winners' => $winnersCount,
                'losers' => $losersCount,
                'total_rewards' => $totalRewards,
                'total_losses' => $totalLosses,
            ]);

            return redirect()
                ->route('admin.signals.show', $signal->id)
                ->with('success', "Signal settled! Winners: {$winnersCount} (Total rewards: " . number_format($totalRewards, 2) . " USDT) | Losers: {$losersCount} (Total losses: " . number_format($totalLosses, 2) . " USDT)");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== SETTLE SIGNAL FAILED ===', [
                'signal_id' => $signal->id,
                'error' => $e->getMessage(),
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
