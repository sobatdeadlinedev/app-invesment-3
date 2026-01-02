<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'amount',
        'total_amount',
        'type',
        'wallet_id',
        'withdrawal_fee',
        'source_user_id',
        'status',
        'payment_method',
        'payment_proof',
        'approved_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'withdrawal_fee' => 'decimal:2',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Relasi ke user pemilik transaksi
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke wallet
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Relasi ke user sumber (untuk commission dari referral)
     */
    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    /**
     * Relasi ke admin yang approve transaksi
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ==================== SCOPES ====================

    /**
     * Scope untuk filter transaksi deposit
     */
    public function scopeDeposit($query)
    {
        return $query->where('type', 'deposit');
    }

    /**
     * Scope untuk filter transaksi withdrawal
     */
    public function scopeWithdrawal($query)
    {
        return $query->where('type', 'withdrawal');
    }

    /**
     * Scope untuk filter transaksi commission
     */
    public function scopeCommission($query)
    {
        return $query->where('type', 'commission');
    }

    /**
     * Scope untuk filter status pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk filter status approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk filter status completed
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Calculate user balance
     * 
     * Logic dengan total_amount:
     * - Untuk deposit & commission: total_amount = amount (tidak ada fee)
     * - Untuk withdrawal: 
     *   - total_amount = yang keluar dari balance (gross)
     *   - amount = yang user terima (net)
     *   - withdrawal_fee = biaya admin
     *   - total_amount = amount + withdrawal_fee
     * 
     * @param int $userId
     * @return float
     */
    public static function getUserBalance($userId)
    {
        // Calculate total deposits (approved only)
        $totalDeposits = self::forUser($userId)
            ->deposit()
            ->approved()
            ->sum('total_amount');

        // Calculate total withdrawals (approved and pending)
        // Gunakan total_amount karena itu yang keluar dari balance
        $totalWithdrawals = self::forUser($userId)
            ->withdrawal()
            ->whereIn('status', ['approved', 'pending'])
            ->sum('total_amount');

        // Calculate total commissions
        $totalCommissions = self::forUser($userId)
            ->commission()
            ->approved()
            ->sum('total_amount');

        return $totalDeposits + $totalCommissions - $totalWithdrawals;
    }

    /**
     * Get user balance breakdown
     * 
     * @param int $userId
     * @return array
     */
    public static function getUserBalanceBreakdown($userId)
    {
        $totalDeposits = self::forUser($userId)
            ->deposit()
            ->approved()
            ->sum('total_amount');

        $totalWithdrawals = self::forUser($userId)
            ->withdrawal()
            ->whereIn('status', ['approved', 'pending'])
            ->sum('total_amount');

        // Net amount yang diterima user (amount, bukan total_amount)
        $totalWithdrawalsNet = self::forUser($userId)
            ->withdrawal()
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');

        $totalWithdrawalFees = self::forUser($userId)
            ->withdrawal()
            ->whereIn('status', ['approved', 'pending'])
            ->sum('withdrawal_fee');

        $totalCommissions = self::forUser($userId)
            ->commission()
            ->approved()
            ->sum('total_amount');

        $balance = $totalDeposits + $totalCommissions - $totalWithdrawals;

        return [
            'total_deposits' => $totalDeposits,
            'total_withdrawals' => $totalWithdrawals, // Gross (keluar dari balance)
            'total_withdrawals_net' => $totalWithdrawalsNet, // Net (yang user terima)
            'total_withdrawal_fees' => $totalWithdrawalFees,
            'total_commissions' => $totalCommissions,
            'balance' => $balance,
        ];
    }

    /**
     * Check if user has sufficient balance
     * 
     * @param int $userId
     * @param float $totalAmount (gross amount yang akan keluar dari balance)
     * @return bool
     */
    public static function hasSufficientBalance($userId, $totalAmount)
    {
        $balance = self::getUserBalance($userId);
        return $balance >= $totalAmount;
    }

    /**
     * Generate unique transaction reference
     * 
     * @param string $prefix (WD, DP, CM)
     * @return string
     */
    public static function generateReference($prefix = 'TXN')
    {
        do {
            $reference = strtoupper($prefix) . '-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('reference', $reference)->exists());

        return $reference;
    }

    /**
     * Get transaction status badge color
     * 
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'completed' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get transaction type badge color
     * 
     * @return string
     */
    public function getTypeColorAttribute()
    {
        return match ($this->type) {
            'deposit' => 'success',
            'withdrawal' => 'danger',
            'commission' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Get formatted amount with sign
     * 
     * @return string
     */
    public function getFormattedAmountAttribute()
    {
        $sign = $this->type === 'withdrawal' ? '-' : '+';
        return $sign . ' ' . number_format($this->amount, 2);
    }

    /**
     * Get formatted total amount with sign
     * 
     * @return string
     */
    public function getFormattedTotalAmountAttribute()
    {
        $sign = $this->type === 'withdrawal' ? '-' : '+';
        return $sign . ' ' . number_format($this->total_amount, 2);
    }
}
