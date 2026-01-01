<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTopic extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'package_id',
        'name',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
