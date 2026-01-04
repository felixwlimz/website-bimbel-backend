<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'max_discount',
        'voucher_type',
        'max_usage',
        'used_count',
        'is_active',
        'expired_at',
        'created_by',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function usages()
    {
        return $this->hasMany(VoucherUsage::class);
    }
}
