<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Answer extends Model
{
    //
    use HasFactory;
     protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'answer';

    protected $fillable = [
        'is_correct'
    ];


    protected function question(){
        return $this->belongsTo(Question::class);
    }
}
