<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingSignal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'entry_price',
        'target_price',
        'stop_loss',
        'status',
        'result',
        'rate_of_return',
        'opened_at',
        'closed_at',
        'settled_at',
        'created_by',
    ];

    protected $casts = [
        'entry_price' => 'decimal:2',
        'target_price' => 'decimal:2',
        'stop_loss' => 'decimal:2',
        'rate_of_return' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'settled_at' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(SignalParticipant::class, 'signal_id');
    }

    // ==================== SCOPES ====================

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeSettled($query)
    {
        return $query->where('status', 'settled');
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if signal is open for joining
     */
    public function isOpen()
    {
        return $this->status === 'open';
    }

    /**
     * Check if signal is closed
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Check if signal is settled
     */
    public function isSettled()
    {
        return $this->status === 'settled';
    }

    /**
     * Get total participants count
     */
    public function getTotalParticipantsAttribute()
    {
        return $this->participants()->count();
    }

    /**
     * Get total bet amount
     */
    public function getTotalBetAmountAttribute()
    {
        return $this->participants()->sum('bet_amount');
    }

    /**
     * Close signal (admin action)
     */
    public function closeSignal($result, $rateOfReturn)
    {
        $this->update([
            'status' => 'closed',
            'result' => $result,
            'rate_of_return' => $rateOfReturn,
            'closed_at' => now(),
        ]);
    }

    /**
     * Mark as settled (setelah semua participant di-settle)
     */
    public function markAsSettled()
    {
        $this->update([
            'status' => 'settled',
            'settled_at' => now(),
        ]);
    }
}
