<?php

namespace App\Http\Controllers\Member;

use App\Models\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
{
    /**
     * Display the deposit form
     */
    public function index()
    {
        $wallet = Config::get('app_wallet_address');
        $walletName = $wallet['name'];
        $walletNumber = $wallet['number'];
        $qrCode = Config::get('app_qr_code')['value'] ?? null;

        // Get user balance using model helper
        $userBalance = Transaction::getUserBalance(auth()->id());

        return view('member.pages.deposit.index', compact('walletNumber', 'walletName', 'qrCode', 'userBalance'));
    }

    /**
     * Process deposit request
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|in:ewallet,qrcode',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
        ], [
            'amount.required' => 'Jumlah deposit harus diisi',
            'amount.min' => 'Minimal deposit adalah 10 USDT',
            'payment_method.required' => 'Metode pembayaran harus dipilih',
            'payment_proof.required' => 'Bukti transfer harus diupload',
            'payment_proof.image' => 'File harus berupa gambar',
            'payment_proof.mimes' => 'Format file harus jpeg, png, atau jpg',
            'payment_proof.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            DB::beginTransaction();

            // Upload payment proof
            $proofPath = $this->uploadPaymentProof($request->file('payment_proof'));

            // Generate unique reference using model helper
            $reference = Transaction::generateReference('DEP');

            $depositAmount = $request->amount;

            // Create transaction
            // Untuk deposit, tidak ada fee jadi amount = total_amount
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'reference' => $reference,
                'amount' => $depositAmount,
                'total_amount' => $depositAmount, // Sama dengan amount karena tidak ada fee
                'type' => 'deposit',
                'wallet_id' => null,
                'withdrawal_fee' => null,
                'source_user_id' => null,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_proof' => $proofPath,
                'approved_by' => null,
            ]);

            DB::commit();

            return redirect()
                ->route('member.deposit.history')
                ->with('success', 'Deposit request submitted successfully! Reference: ' . $reference);
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded file if transaction failed
            if (isset($proofPath) && Storage::disk('public')->exists($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }

            // Log error for debugging
            Log::error('Deposit failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit deposit request. Please try again.');
        }
    }

    /**
     * Show deposit history
     */
    public function history()
    {
        // Get all deposits with pagination
        $transactions = Transaction::forUser(auth()->id())
            ->deposit()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Count summary
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

    /**
     * Upload payment proof file
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function uploadPaymentProof($file)
    {
        if (!$file) {
            throw new \Exception('Payment proof file is required');
        }

        $fileName = 'deposit_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('payment_proofs', $fileName, 'public');
    }

    /**
     * Get pending deposits count (optional - for notifications)
     */
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
