<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ReferralUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Transaction::with(['user'])
            ->deposit()
            ->latest()
            ->paginate(10);

        return view('admin.pages.deposit.index', compact('deposits'));
    }

    public function show($id)
    {
        $deposit = Transaction::with(['user', 'approver'])
            ->deposit()
            ->findOrFail($id);

        return view('admin.pages.deposit.detail', compact('deposit'));
    }

    public function approve($id)
    {
        $deposit = Transaction::deposit()->findOrFail($id);

        if ($deposit->status !== 'pending') {
            return redirect()->route('admin.deposit.index')
                ->with('error', 'This deposit has already been processed.');
        }

        DB::beginTransaction();
        try {
            // Update deposit status
            $deposit->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
            ]);

            // UPDATED - Add to exchange balance
            $user = $deposit->user;
            $user->addExchangeBalance($deposit->total_amount);

            // Process referral commissions ONLY for first deposit
            $this->processReferralCommissions($deposit);

            DB::commit();

            return redirect()->route('admin.deposit.index')
                ->with('success', 'Deposit has been approved successfully and added to Exchange Balance.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.deposit.index')
                ->with('error', 'Failed to approve deposit: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $deposit = Transaction::deposit()->findOrFail($id);

        if ($deposit->status !== 'pending') {
            return redirect()->route('admin.deposit.index')
                ->with('error', 'This deposit has already been processed.');
        }

        $deposit->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.deposit.index')
            ->with('success', 'Deposit has been rejected.');
    }

    /**
     * Process referral commissions - UPDATED to add to exchange balance
     */
    private function processReferralCommissions(Transaction $deposit)
    {
        $previousApprovedDeposits = Transaction::where('user_id', $deposit->user_id)
            ->where('type', 'deposit')
            ->where('status', 'approved')
            ->where('id', '!=', $deposit->id)
            ->count();

        if ($previousApprovedDeposits > 0) {
            return;
        }

        $referralUsage = ReferralUsage::where('referred_id', $deposit->user_id)->first();

        if (!$referralUsage) {
            return;
        }

        $depositAmount = $deposit->total_amount;

        // Level 1: 5%
        $level1Commission = $depositAmount * 0.05;
        $this->createCommissionTransaction(
            $referralUsage->referrer_id,
            $deposit->user_id,
            $level1Commission,
            'Level 1 Commission - First Deposit'
        );

        // Level 2: 2%
        $level2ReferralUsage = ReferralUsage::where('referred_id', $referralUsage->referrer_id)->first();

        if ($level2ReferralUsage) {
            $level2Commission = $depositAmount * 0.02;
            $this->createCommissionTransaction(
                $level2ReferralUsage->referrer_id,
                $deposit->user_id,
                $level2Commission,
                'Level 2 Commission - First Deposit'
            );
        }
    }

    /**
     * Create commission transaction - UPDATED to add to exchange balance
     */
    private function createCommissionTransaction($userId, $sourceUserId, $amount, $note = '')
    {
        // Add commission to exchange balance
        $user = \App\Models\User::find($userId);
        $user->addExchangeBalance($amount);

        return Transaction::create([
            'user_id' => $userId,
            'source_user_id' => $sourceUserId,
            'reference' => Transaction::generateReference('CM'),
            'amount' => $amount,
            'total_amount' => $amount,
            'type' => 'commission',
            'balance_type' => 'exchange', // Commission masuk ke exchange
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);
    }
}
