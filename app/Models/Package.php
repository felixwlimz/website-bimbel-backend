<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Package extends Model
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
    protected $fillable = [
        'title',
        'type',
        'description',
        'price',
        'duration_minutes',
        'thumbnail',
        'is_published',
    ];

    protected $table = 'packages';
    public $incrementing = false;
    protected $keyType = 'string';

    public function questions()
    {
        return $this->hasMany(Question::class, 'package_id', 'id');
    }

    public function material()
    {
        return $this->hasMany(Material::class, 'package_id', 'id');
    }

    public function answerSheets()
    {
        return $this->hasMany(AnswerSheet::class, 'package_id', 'id');
    }
}
