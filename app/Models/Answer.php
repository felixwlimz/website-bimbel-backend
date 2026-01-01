<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'answer_sheet_id',
        'question_id',
        'option_id',
        'last_saved_at',
    ];

    protected $casts = [
        'last_saved_at' => 'datetime',
    ];

    public function answerSheet()
    {
        return $this->belongsTo(AnswerSheet::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
