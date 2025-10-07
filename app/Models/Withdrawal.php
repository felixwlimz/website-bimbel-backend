<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Withdrawal extends Model
{

    use HasFactory;
    //

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
        'amount',
        'status',
        'account_number',
        'approved_by',
        'bank_name',
        'account_name',
        'affiliate_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }
}
