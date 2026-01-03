<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'affiliate_id',
        'amount',
        'bank_name',
        'account_number',
        'account_name',
        'status',
        'approved_by',
        'approved_at',
        'paid_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
