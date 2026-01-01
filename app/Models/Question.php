<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'package_id',
        'title',
        'content',
        'media_type',
        'media_path',
        'weight',
        'sub_topic_id',
        'explanation',
    ];

    protected $hidden = [
        'explanation',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
