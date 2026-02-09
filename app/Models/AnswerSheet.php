<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnswerSheet extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'package_id',
        'status',
        'started_at',
        'ends_at',
        'submitted_at',
        'total_score',
        'passing',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'submitted_at' => 'datetime',
        'passing' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function subTopicScores()
    {
        return $this->hasMany(SubTopicScore::class);
    }
}
