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
        if (!auth()->user()->is_verified) {
            return redirect()
                ->route('member.profile.index')
                ->with('error', 'Akun Anda belum terverifikasi. Silakan hubungi admin untuk verifikasi akun.');
        }

        $wallets = Wallet::where('user_id', auth()->id())->get();

        // UPDATED - gunakan exchange_balance
        $user = auth()->user();
        $exchangeBalance = $user->exchange_balance;

        return view('member.pages.withdraw.index', compact('wallets', 'exchangeBalance'));
    }

    /**
     * Process withdrawal request
     */
    public function store(Request $request)
    {
        if (!auth()->user()->is_verified) {
            return redirect()
                ->route('member.profile.index')
                ->with('error', 'Akun Anda belum terverifikasi. Withdrawal tidak dapat diproses.');
        }

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
            $wallet = Wallet::where('id', $request->wallet_id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$wallet) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Wallet account tidak ditemukan');
            }

            $user = auth()->user();
            $requestedAmount = $request->amount;

            // Calculate withdrawal fee (5%)
            $withdrawalFee = $requestedAmount * 0.05;
            $netAmount = $requestedAmount - $withdrawalFee;
            $totalAmount = $requestedAmount;

            // UPDATED - Check exchange balance
            if ($user->exchange_balance < $totalAmount) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Saldo Exchange tidak mencukupi. Saldo Anda: ' . number_format($user->exchange_balance, 2) . ' USDT. Silakan transfer dari Trade Balance terlebih dahulu.');
            }

            DB::beginTransaction();

            $reference = Transaction::generateReference('WD');

            // Create transaction - UPDATED: balance_type = 'exchange'
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'reference' => $reference,
                'amount' => $netAmount,
                'total_amount' => $totalAmount,
                'type' => 'withdrawal',
                'balance_type' => 'exchange', // NEW - withdrawal dari exchange
                'wallet_id' => $request->wallet_id,
                'withdrawal_fee' => $withdrawalFee,
                'source_user_id' => null,
                'status' => 'pending',
                'payment_method' => 'wallet_transfer',
                'payment_proof' => null,
                'approved_by' => null,
            ]);

            // UPDATED - Deduct exchange balance immediately (pending state)
            $user->deductExchangeBalance($totalAmount);

            DB::commit();

            return redirect()
                ->route('member.withdraw.history')
                ->with('success', 'Withdrawal request submitted successfully! Reference: ' . $reference . '. You will receive: ' . number_format($netAmount, 2) . ' USDT');
        } catch (\Exception $e) {
            DB::rollBack();

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
        $transactions = Transaction::forUser(auth()->id())
            ->withdrawal()
            ->with('wallet')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
     * Cancel withdrawal request
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

            // UPDATED - Return balance to exchange
            $user = auth()->user();
            $user->addExchangeBalance($transaction->total_amount);

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
