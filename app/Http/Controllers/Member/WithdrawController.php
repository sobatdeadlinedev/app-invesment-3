<?php

namespace App\Http\Controllers\Member;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{
    /**
     * Display the withdrawal form
     */
    public function index()
    {
        $wallets = Wallet::where('user_id', auth()->id())->get();
        $userBalance = Transaction::getUserBalance(auth()->id());

        return view('member.pages.withdraw.index', compact('wallets', 'userBalance'));
    }

    /**
     * Process withdrawal request
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'wallet_id' => 'required|exists:wallets,id',
        ], [
            'amount.required' => 'Jumlah withdrawal harus diisi',
            'amount.min' => 'Minimal withdrawal adalah 10 USDT',
            'wallet_id.required' => 'Wallet account harus dipilih',
            'wallet_id.exists' => 'Wallet account tidak valid',
        ]);

        try {
            // Verify wallet belongs to user
            $wallet = Wallet::where('id', $request->wallet_id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$wallet) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Wallet account tidak ditemukan');
            }

            // User input adalah amount yang ingin ditarik (gross/total)
            $requestedAmount = $request->amount; // Misal: 250

            // Calculate withdrawal fee (2%)
            $withdrawalFee = $requestedAmount * 0.02; // 250 * 0.02 = 5

            // Net amount yang akan diterima user
            $netAmount = $requestedAmount - $withdrawalFee; // 250 - 5 = 245

            // Total yang keluar dari balance (sama dengan requested)
            $totalAmount = $requestedAmount; // 250

            // Check user balance - cek apakah balance cukup untuk total_amount
            if (!Transaction::hasSufficientBalance(auth()->id(), $totalAmount)) {
                $currentBalance = Transaction::getUserBalance(auth()->id());

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Saldo tidak mencukupi. Saldo Anda: ' . number_format($currentBalance, 2) . ' USDT');
            }

            DB::beginTransaction();

            // Generate unique reference using model helper
            $reference = Transaction::generateReference('WD');

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'reference' => $reference,
                'amount' => $netAmount,              // 245 (yang user terima)
                'total_amount' => $totalAmount,      // 250 (yang keluar dari balance)
                'type' => 'withdrawal',
                'wallet_id' => $request->wallet_id,
                'withdrawal_fee' => $withdrawalFee,  // 5 (fee)
                'source_user_id' => null,
                'status' => 'pending',
                'payment_method' => 'wallet_transfer',
                'payment_proof' => null,
                'approved_by' => null,
            ]);

            DB::commit();

            return redirect()
                ->route('member.withdraw.history')
                ->with('success', 'Withdrawal request submitted successfully! Reference: ' . $reference . '. You will receive: ' . number_format($netAmount, 2) . ' USDT');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error for debugging
            Log::error('Withdrawal failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit withdrawal request. Please try again.');
        }
    }

    /**
     * Show withdrawal history
     */
    public function history()
    {
        // Get all withdrawals with pagination
        $transactions = Transaction::forUser(auth()->id())
            ->withdrawal()
            ->with('wallet')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Count summary
        $pendingCount = Transaction::forUser(auth()->id())
            ->withdrawal()
            ->pending()
            ->count();

        $completedCount = Transaction::forUser(auth()->id())
            ->withdrawal()
            ->whereIn('status', ['approved', 'completed'])
            ->count();

        return view('member.pages.withdraw.history', compact('transactions', 'pendingCount', 'completedCount'));
    }

    /**
     * Cancel withdrawal request (only for pending status)
     */
    public function cancel($reference)
    {
        try {
            $transaction = Transaction::where('reference', $reference)
                ->where('user_id', auth()->id())
                ->where('type', 'withdrawal')
                ->where('status', 'pending')
                ->first();

            if (!$transaction) {
                return redirect()
                    ->route('member.withdraw.history')
                    ->with('error', 'Withdrawal request not found or cannot be cancelled');
            }

            DB::beginTransaction();

            // Update status to cancelled
            $transaction->update([
                'status' => 'cancelled',
            ]);

            DB::commit();

            return redirect()
                ->route('member.withdraw.history')
                ->with('success', 'Withdrawal request cancelled successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Cancel withdrawal failed: ' . $e->getMessage());

            return redirect()
                ->route('member.withdraw.history')
                ->with('error', 'Failed to cancel withdrawal request');
        }
    }
}
