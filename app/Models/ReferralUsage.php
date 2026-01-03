<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'referral_code',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    // Relationships
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    // Scopes
    public function scopeByReferrer($query, $userId)
    {
        return $query->where('referrer_id', $userId);
    }

    public function scopeByReferred($query, $userId)
    {
        return $query->where('referred_id', $userId);
    }

    public function scopeByReferralCode($query, $code)
    {
        return $query->where('referral_code', $code);
    }
}
