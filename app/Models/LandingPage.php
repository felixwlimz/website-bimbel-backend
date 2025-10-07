<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LandingPage extends Model
{
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

    protected $table = 'landing_page';

    protected $fillable = [
        'title',
        'file_path',
        'description',
        'slug',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
