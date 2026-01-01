<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'package_id',
        'voucher_id',
        'affiliate_id',
        'invoice_number',
        'original_amount',
        'discount_amount',
        'final_amount',
        'payment_method',
        'payment_reference',
        'status',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
