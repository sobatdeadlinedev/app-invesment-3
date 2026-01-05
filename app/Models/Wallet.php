<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'account_name',
        'account_number',
    ];

    // Konstanta untuk type
    const TYPE_TRC20 = 'trc20';
    const TYPE_BEP20 = 'bep20';

    public static function getTypes()
    {
        return [
            self::TYPE_TRC20 => 'TRC20 (TRON)',
            self::TYPE_BEP20 => 'BEP20 (BSC)',
        ];
    }

    public function getTypeLabel()
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
