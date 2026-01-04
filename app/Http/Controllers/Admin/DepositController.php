<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

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

        // Update deposit status
        $deposit->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.deposit.index')
            ->with('success', 'Deposit has been approved successfully.');
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
}
