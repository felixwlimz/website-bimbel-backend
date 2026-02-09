<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTopicScore extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'answer_sheet_id',
        'sub_topic_id',
        'total_questions',
        'correct_answers',
        'total_score',
        'passing_grade',
        'is_passed',
    ];

    protected $casts = [
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'total_score' => 'integer',
        'passing_grade' => 'integer',
        'is_passed' => 'boolean',
    ];

    public function answerSheet()
    {
        return $this->belongsTo(AnswerSheet::class);
    }

    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class);
    }
}
