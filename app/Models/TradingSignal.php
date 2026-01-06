<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingSignal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'coin',
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

    // ==================== COIN CONFIGURATION ====================

    /**
     * Available coins for trading signals
     */
    public static function getAvailableCoins()
    {
        return [
            'BTC' => [
                'name' => 'Bitcoin',
                'symbol' => 'BTC/USDT',
                'icon' => 'bi-currency-bitcoin',
                'color' => '#f7931a',
            ],
            'ETH' => [
                'name' => 'Ethereum',
                'symbol' => 'ETH/USDT',
                'icon' => 'bi-currency-exchange',
                'color' => '#627eea',
            ],
            'DOGE' => [
                'name' => 'Dogecoin',
                'symbol' => 'DOGE/USDT',
                'icon' => 'bi-coin',
                'color' => '#c2a633',
            ],
            'BNB' => [
                'name' => 'Binance Coin',
                'symbol' => 'BNB/USDT',
                'icon' => 'bi-triangle-fill',
                'color' => '#f3ba2f',
            ],
            'SOL' => [
                'name' => 'Solana',
                'symbol' => 'SOL/USDT',
                'icon' => 'bi-sun-fill',
                'color' => '#14f195',
            ],
            'XRP' => [
                'name' => 'Ripple',
                'symbol' => 'XRP/USDT',
                'icon' => 'bi-water',
                'color' => '#23292f',
            ],
        ];
    }

    /**
     * Get coin info
     */
    public function getCoinInfo()
    {
        $coins = self::getAvailableCoins();
        return $coins[$this->coin] ?? $coins['BTC'];
    }

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

    public function scopeForCoin($query, $coin)
    {
        return $query->where('coin', strtoupper($coin));
    }

    // ==================== HELPER METHODS ====================

    public function isOpen()
    {
        return $this->status === 'open';
    }

    public function isClosed()
    {
        return $this->status === 'closed';
    }

    public function isSettled()
    {
        return $this->status === 'settled';
    }

    public function getTotalParticipantsAttribute()
    {
        return $this->participants()->count();
    }

    public function getTotalBetAmountAttribute()
    {
        return $this->participants()->sum('bet_amount');
    }

    /**
     * Close signal - set opened_at saat status closed
     */
    public function closeSignal($result, $rateOfReturn)
    {
        $this->update([
            'status' => 'closed',
            'result' => $result,
            'rate_of_return' => $rateOfReturn,
            'opened_at' => now(), // Set opened_at saat close
        ]);
    }

    /**
     * Mark as settled - set closed_at saat status settled
     */
    public function markAsSettled()
    {
        $this->update([
            'status' => 'settled',
            'settled_at' => now(),
            'closed_at' => now(), // Set closed_at saat settled
        ]);
    }
}
