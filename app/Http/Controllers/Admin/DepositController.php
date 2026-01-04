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

        // Check if already processed
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

            // Process referral commissions ONLY for first deposit
            $this->processReferralCommissions($deposit);

            DB::commit();

            return redirect()->route('admin.deposit.index')
                ->with('success', 'Deposit has been approved successfully and referral commissions have been processed.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.deposit.index')
                ->with('error', 'Failed to approve deposit: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $deposit = Transaction::deposit()->findOrFail($id);

        // Check if already processed
        if ($deposit->status !== 'pending') {
            return redirect()->route('admin.deposit.index')
                ->with('error', 'This deposit has already been processed.');
        }

        // Update deposit status
        $deposit->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.deposit.index')
            ->with('success', 'Deposit has been rejected.');
    }

    /**
     * Process referral commissions for approved deposit
     * ONLY for FIRST approved deposit
     * 
     * @param Transaction $deposit
     * @return void
     */
    private function processReferralCommissions(Transaction $deposit)
    {
        // Check if this is the FIRST approved deposit for this user
        $previousApprovedDeposits = Transaction::where('user_id', $deposit->user_id)
            ->where('type', 'deposit')
            ->where('status', 'approved')
            ->where('id', '!=', $deposit->id) // Exclude current deposit
            ->count();

        // If user already has approved deposits before, skip commission
        if ($previousApprovedDeposits > 0) {
            return;
        }

        // Get referral usage for the user who deposited
        $referralUsage = ReferralUsage::where('referred_id', $deposit->user_id)->first();

        if (!$referralUsage) {
            // User tidak menggunakan referral code, skip commission
            return;
        }

        $depositAmount = $deposit->total_amount;

        // Level 1: Direct referrer gets 5%
        $level1Commission = $depositAmount * 0.05;
        $this->createCommissionTransaction(
            $referralUsage->referrer_id,
            $deposit->user_id,
            $level1Commission,
            'Level 1 Commission - First Deposit'
        );

        // Level 2: Check if level 1 referrer was also referred by someone
        $level2ReferralUsage = ReferralUsage::where('referred_id', $referralUsage->referrer_id)->first();

        if ($level2ReferralUsage) {
            // Level 2 referrer gets 2%
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
     * Create commission transaction
     * 
     * @param int $userId - User who receives commission
     * @param int $sourceUserId - User who made the deposit
     * @param float $amount - Commission amount
     * @param string $note - Optional note
     * @return Transaction
     */
    private function createCommissionTransaction($userId, $sourceUserId, $amount, $note = '')
    {
        return Transaction::create([
            'user_id' => $userId,
            'source_user_id' => $sourceUserId,
            'reference' => Transaction::generateReference('CM'),
            'amount' => $amount,
            'total_amount' => $amount,
            'type' => 'commission',
            'status' => 'approved', // Commission langsung approved
            'approved_by' => auth()->id(),
        ]);
    }
}
