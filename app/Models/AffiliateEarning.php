<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffiliateEarning extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'affiliate_id',
        'transaction_id',
        'commission_rate',
        'commission_amount',
        'locked_until',
        'status',
    ];

    protected $casts = [
        'locked_until' => 'datetime',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
