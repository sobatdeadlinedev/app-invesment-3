<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Transaction::with(['user', 'wallet'])
            ->withdrawal()
            ->latest()
            ->paginate(10);

        return view('admin.pages.withdrawal.index', compact('withdrawals'));
    }

    public function show($id)
    {
        $withdrawal = Transaction::with(['user', 'wallet', 'approver'])
            ->withdrawal()
            ->findOrFail($id);

        return view('admin.pages.withdrawal.detail', compact('withdrawal'));
    }

    public function approve(Request $request, $id)
    {
        $withdrawal = Transaction::withdrawal()->findOrFail($id);

        // Check if already processed
        if ($withdrawal->status !== 'pending') {
            return redirect()->route('admin.withdrawal.index')
                ->with('error', 'This withdrawal has already been processed.');
        }

        // Validate payment proof upload - OPTIONAL
        $request->validate([
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB - CHANGED to nullable
        ], [
            'payment_proof.image' => 'Payment proof must be an image.',
            'payment_proof.mimes' => 'Payment proof must be a file of type: jpeg, png, jpg.',
            'payment_proof.max' => 'Payment proof must not be greater than 5MB.',
        ]);

        try {
            DB::beginTransaction();

            $paymentProofPath = null;

            // Store payment proof if uploaded
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            // Update withdrawal status
            $withdrawal->update([
                'status' => 'approved',
                'payment_proof' => $paymentProofPath,
                'approved_by' => auth()->id(),
            ]);

            // Balance sudah dikurangi saat pending, tidak perlu update lagi

            DB::commit();

            return redirect()->route('admin.withdrawal.index')
                ->with('success', 'Withdrawal has been approved and completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.withdrawal.index')
                ->with('error', 'Failed to approve withdrawal: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $withdrawal = Transaction::withdrawal()->findOrFail($id);

        // Check if already processed
        if ($withdrawal->status !== 'pending') {
            return redirect()->route('admin.withdrawal.index')
                ->with('error', 'This withdrawal has already been processed.');
        }

        try {
            DB::beginTransaction();

            $user = $withdrawal->user;

            // Return balance to exchange balance
            $user->addExchangeBalance($withdrawal->total_amount);

            // Update withdrawal status
            $withdrawal->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.withdrawal.index')
                ->with('success', 'Withdrawal has been rejected and balance has been returned to user.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.withdrawal.index')
                ->with('error', 'Failed to reject withdrawal: ' . $e->getMessage());
        }
    }
}
