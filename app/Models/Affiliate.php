<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Withdrawal;
use Illuminate\Support\Str;
 

class Affiliate extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id',
        'commission_rate',
        'is_approved',
    ];


    protected $table = 'affiliate';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'affiliate_id', 'id');
    }

    public function affiliateEarnings()
    {
        return $this->hasMany(AffiliateEarnings::class, 'affiliate_id', 'id');
    }
}
