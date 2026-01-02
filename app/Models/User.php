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
        'password',
        'refferal_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
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
}
