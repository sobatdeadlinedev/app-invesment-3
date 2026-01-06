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

        $user = auth()->user();
        $userBalance = $user->exchange_balance;

        return view('member.pages.withdraw.index', compact('wallets', 'userBalance'));
    }

    /**
     * Calculate withdrawal fee based on amount
     */
    private function calculateWithdrawalFee($amount)
    {
        if ($amount < 100) {
            return 5; // Fixed 5 USDT for withdrawals below 100
        } else {
            return $amount * 0.05; // 5% for withdrawals 100 and above
        }
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
            'amount' => 'required|numeric|min:20',
            'wallet_id' => 'required|exists:wallets,id',
        ], [
            'amount.required' => 'Jumlah withdrawal harus diisi',
            'amount.min' => 'Minimal withdrawal adalah 20 USDT',
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

            // Calculate withdrawal fee based on new rules
            $withdrawalFee = $this->calculateWithdrawalFee($requestedAmount);
            $netAmount = $requestedAmount - $withdrawalFee;
            $totalAmount = $requestedAmount;

            // Check if net amount is positive
            if ($netAmount <= 0) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Jumlah withdrawal terlalu kecil. Setelah dikurangi fee, Anda akan menerima 0 USDT atau kurang.');
            }

            // Check exchange balance
            if ($user->exchange_balance < $totalAmount) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Saldo Exchange tidak mencukupi. Saldo Anda: ' . number_format($user->exchange_balance, 2) . ' USDT. Silakan transfer dari Trade Balance terlebih dahulu.');
            }

            DB::beginTransaction();

            $reference = Transaction::generateReference('WD');

            // Create transaction - balance_type = 'exchange'
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'reference' => $reference,
                'amount' => $netAmount,
                'total_amount' => $totalAmount,
                'type' => 'withdrawal',
                'balance_type' => 'exchange',
                'wallet_id' => $request->wallet_id,
                'withdrawal_fee' => $withdrawalFee,
                'source_user_id' => null,
                'status' => 'pending',
                'payment_method' => 'wallet_transfer',
                'payment_proof' => null,
                'approved_by' => null,
            ]);

            // Deduct exchange balance immediately (pending state)
            $user->deductExchangeBalance($totalAmount);

            DB::commit();

            return redirect()
                ->route('member.withdraw.history')
                ->with('success', 'Withdrawal request submitted successfully! Reference: ' . $reference . '. Fee: ' . number_format($withdrawalFee, 2) . ' USDT. You will receive: ' . number_format($netAmount, 2) . ' USDT');
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

            // Return balance to exchange
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
