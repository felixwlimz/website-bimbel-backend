<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Question extends Model
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

    protected $fillable = [
        'judulSoal',
        'jenisSoal',
        'isiSoal',
        'mediaSoal',
        'bobot',
        'jawabanBenar',
        'pembahasan',
        'subMateri',
        'package_id',
    ];

    protected $table = 'questions';
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }
}
