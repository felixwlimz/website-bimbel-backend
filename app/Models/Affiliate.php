<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Affiliate extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'code',
        'status',
    ];

    /* =====================
     | RELATIONS
     ===================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(AffiliateBankAccount::class);
    }

    public function activeBankAccount()
    {
        return $this->hasOne(AffiliateBankAccount::class)
            ->where('is_active', true);
    }

    public function earnings()
    {
        return $this->hasMany(AffiliateEarning::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
