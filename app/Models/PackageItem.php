<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageItem extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'package_id',
        'item_id',
        'item_type', // material | tryout
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
