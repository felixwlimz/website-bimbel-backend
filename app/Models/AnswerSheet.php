<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerSheet extends Model
{
    //
    use HasFactory;
    
    protected $fillable = [
        'total_score',
        'testing'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


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
        return $this->hasMany(Answer::class, 'answer_sheet_id', 'id');
    }
}
