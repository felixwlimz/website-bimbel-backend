<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateEarnings extends Model
{
    //
    use HasFactory;
    protected $table = 'affiliate_earnings';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['status'];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
