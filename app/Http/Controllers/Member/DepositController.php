<?php

namespace App\Http\Controllers\Member;

use App\Models\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;

class DepositController extends Controller
{
    /**
     * Display the deposit form
     */
    public function index()
    {
        // Get both wallet types
        $walletTrc20 = Config::get('app_wallet_trc20', ['name' => 'TRON Network (TRC20)', 'address' => '']);
        $walletBep20 = Config::get('app_wallet_bep20', ['name' => 'Binance Smart Chain (BEP20)', 'address' => '']);

        // Get user balance
        $user = auth()->user();
        $exchangeBalance = $user->exchange_balance;
        $tradeBalance = $user->trade_balance;
        $userBalance = $user->exchange_balance + $user->trade_balance;

        return view('member.pages.deposit.index', compact(
            'walletTrc20',
            'walletBep20',
            'exchangeBalance',
            'tradeBalance',
            'userBalance'
        ));
    }

    /**
     * Process deposit request
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'wallet_type' => 'required|in:trc20,bep20',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'amount.required' => 'Jumlah deposit harus diisi',
            'amount.min' => 'Minimal deposit adalah 10 USDT',
            'wallet_type.required' => 'Pilih tipe jaringan',
            'wallet_type.in' => 'Tipe jaringan tidak valid',
            'payment_proof.required' => 'Bukti transfer harus diupload',
            'payment_proof.image' => 'File harus berupa gambar',
            'payment_proof.mimes' => 'Format file harus jpeg, png, atau jpg',
            'payment_proof.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            DB::beginTransaction();

            // Upload payment proof
            $proofPath = $this->uploadPaymentProof($request->file('payment_proof'));

            // Generate unique reference
            $reference = Transaction::generateReference('DEP');

            $depositAmount = $request->amount;

            // Get wallet type label for payment method
            $walletTypeLabel = $request->wallet_type === 'trc20' ? 'TRC20 (TRON)' : 'BEP20 (BSC)';

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'reference' => $reference,
                'amount' => $depositAmount,
                'total_amount' => $depositAmount,
                'type' => 'deposit',
                'balance_type' => 'exchange',
                'wallet_id' => null,
                'withdrawal_fee' => null,
                'source_user_id' => null,
                'status' => 'pending',
                'payment_method' => $walletTypeLabel, // Store wallet type as payment method
                'payment_proof' => $proofPath,
                'approved_by' => null,
            ]);

            // Send email notification to admin
            $this->sendAdminNotification($transaction);

            DB::commit();

            return redirect()
                ->route('member.deposit.history')
                ->with('success', 'Deposit request submitted successfully! Reference: ' . $reference);
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($proofPath) && Storage::disk('public')->exists($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }

            Log::error('Deposit failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit deposit request. Please try again.');
        }
    }

    /**
     * Send email notification to admin
     */
    private function sendAdminNotification($transaction)
    {
        try {
            $adminEmail = Config::get('app_email')['value'] ?? null;

            if (!$adminEmail) {
                Log::warning('Admin email not configured');
                return;
            }

            $user = $transaction->user;

            $data = [
                'reference' => $transaction->reference,
                'amount' => $transaction->amount,
                'payment_method' => $transaction->payment_method,
                'created_at' => $transaction->created_at->format('d M Y H:i'),
            ];

            Mail::to($adminEmail)->send(new AdminNotificationMail(
                'deposit',
                $data,
                $user->name,
                $user->email
            ));
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification email: ' . $e->getMessage());
        }
    }

    /**
     * Show deposit history
     */
    public function history()
    {
        $transactions = Transaction::forUser(auth()->id())
            ->deposit()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pendingCount = Transaction::forUser(auth()->id())
            ->deposit()
            ->pending()
            ->count();

        $completedCount = Transaction::forUser(auth()->id())
            ->deposit()
            ->whereIn('status', ['approved', 'completed'])
            ->count();

        return view('member.pages.deposit.history', compact('transactions', 'pendingCount', 'completedCount'));
    }

    private function uploadPaymentProof($file)
    {
        if (!$file) {
            throw new \Exception('Payment proof file is required');
        }

        $fileName = 'deposit_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('payment_proofs', $fileName, 'public');
    }

    public function getPendingCount()
    {
        $count = Transaction::forUser(auth()->id())
            ->deposit()
            ->pending()
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
}
