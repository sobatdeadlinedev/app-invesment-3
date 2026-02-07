<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignalParticipant extends Model
{
    use HasFactory;

    // ✅ DISABLE auto timestamps Laravel
    public $timestamps = false;

    protected $fillable = [
        'signal_id',
        'user_id',
        'bet_amount',
        'profit_loss',
        'fee_amount',
        'status',
        'joined_at',  // ⚠️ Ini masih fillable, jadi bisa di-update
        'settled_at',
    ];

    // ✅ TAMBAHKAN INI - Protect joined_at dari mass assignment update
    protected $guarded = ['id', 'joined_at'];

    protected $casts = [
        'bet_amount' => 'decimal:2',
        'profit_loss' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'joined_at' => 'datetime',
        'settled_at' => 'datetime',
    ];

    // ==================== BOOT METHOD ====================

    protected static function boot()
    {
        parent::boot();

        // Set joined_at hanya saat create pertama kali
        static::creating(function ($participant) {
            if (empty($participant->joined_at)) {
                $participant->joined_at = now();
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    public function signal()
    {
        return $this->belongsTo(TradingSignal::class, 'signal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ==================== SCOPES ====================

    public function scopeJoined($query)
    {
        return $query->where('status', 'joined');
    }

    public function scopeSettled($query)
    {
        return $query->where('status', 'settled');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ==================== HELPER METHODS ====================

    public function isSettled()
    {
        return $this->status === 'settled';
    }

    public function getNetResultAttribute()
    {
        return $this->profit_loss - $this->fee_amount;
    }

    public function getFinalBalanceChangeAttribute()
    {
        return $this->bet_amount + $this->profit_loss - $this->fee_amount;
    }
}
