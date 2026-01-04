<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'password',
        'refferal_code',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relation
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function commissionSources()
    {
        return $this->hasMany(Transaction::class, 'source_user_id');
    }

    public function approvedTransactions()
    {
        return $this->hasMany(Transaction::class, 'approved_by');
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->refferal_code)) {
                $user->refferal_code = self::generateUniqueReferralCode();
            }
        });
    }

    // Generate 6-char alphanumeric referral code
    private static function generateUniqueReferralCode(): string
    {
        $exists = true;

        while ($exists) {
            $code = strtoupper(Str::random(6));

            // Ensure at least 1 letter and 1 number
            if (!preg_match('/[A-Z]/', $code) || !preg_match('/[0-9]/', $code)) {
                continue;
            }

            $exists = self::where('refferal_code', $code)->exists();
        }

        return $code;
    }

    // get current user
    public static function current()
    {
        return auth()->user();
    }

    public function referrals()
    {
        return $this->hasMany(ReferralUsage::class, 'referrer_id');
    }

    // Referral usage ketika user ini menggunakan kode referral orang lain
    public function usedReferral()
    {
        return $this->hasOne(ReferralUsage::class, 'referred_id');
    }

    // Get users yang direferensikan (referred users)
    public function referredUsers()
    {
        return $this->hasManyThrough(
            User::class,
            ReferralUsage::class,
            'referrer_id',
            'id',
            'id',
            'referred_id'
        );
    }

    // Get total referral count
    public function getTotalReferralsAttribute()
    {
        return $this->referrals()->count();
    }

    // Helper methods untuk verifikasi dokumen
    public function verify()
    {
        $this->update(['is_verified' => true]);
    }

    public function unverify()
    {
        $this->update(['is_verified' => false]);
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    // Scope untuk query
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }
}
