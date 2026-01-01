<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'question_id',
        'key',
        'content',
        'is_correct',
        'order',
    ];

    protected $hidden = [
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
