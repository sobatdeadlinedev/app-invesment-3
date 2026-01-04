<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
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

        // Validate payment proof upload
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
        ], [
            'payment_proof.required' => 'Payment proof is required to approve withdrawal.',
            'payment_proof.image' => 'Payment proof must be an image.',
            'payment_proof.mimes' => 'Payment proof must be a file of type: jpeg, png, jpg.',
            'payment_proof.max' => 'Payment proof must not be greater than 5MB.',
        ]);

        // Store payment proof
        $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update withdrawal status
        $withdrawal->update([
            'status' => 'completed',
            'payment_proof' => $paymentProofPath,
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.withdrawal.index')
            ->with('success', 'Withdrawal has been approved and completed successfully.');
    }

    public function reject($id)
    {
        $withdrawal = Transaction::withdrawal()->findOrFail($id);

        // Check if already processed
        if ($withdrawal->status !== 'pending') {
            return redirect()->route('admin.withdrawal.index')
                ->with('error', 'This withdrawal has already been processed.');
        }

        // Update withdrawal status
        $withdrawal->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.withdrawal.index')
            ->with('success', 'Withdrawal has been rejected.');
    }
}
