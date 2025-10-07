<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    //
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public $incrementing = false;
    protected $keyType = 'string';
     protected $fillable = [
        'id',
        'user_id',
        'package_id',
        'voucher_id',
        'payment_method',
        'invoice_number',
        'amount',
        'discount_amount',
        'status',
        'snap_token',
    ];

    protected $table = 'transactions';
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}
